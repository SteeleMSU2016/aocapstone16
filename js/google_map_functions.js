/**
 * Created by cse498 on 2/2/16.
 */
var overlay;
var map;
var bounds;

var NoClaimMarkers = [];
var NewClaimMarkers = [];
var AssignedClaimMarkers  =[];
var ClosedClaimMarkers = [];
WeatherOverlay.prototype = new google.maps.OverlayView();


/**
 *
 * Google Map Creation And Reconstruction
 * Instantiates a google Map and Calls address() to set Policy Holders Address Markers
 *
 * Calls displayDisasterPolygon() to draw polygon from database to show Addresses in
 * Disaster Data Set
 *
 * Adds Drawing Manager to Map and adds listeners for creating polygon
 *
 * Sets Legends on Map for both Weather Overlay and Policy Address Claims Status
 * @constructor
 *
 * */
function initMap() {
    //var myLatLng = {lat: 42.724152, lng: -84.48136};
    var myLatLng = {lat: 29.7604, lng: -95.3698};


    var geocoder = new google.maps.Geocoder();

    map = new google.maps.Map(document.getElementById('map'), {
        center: myLatLng,
        mapTypeId: google.maps.MapTypeId.HYBRID,
        zoom: 10

    });


    address(geocoder, map);

    displayDisasterPolygon(map);

    bounds = new google.maps.LatLngBounds(
        new google.maps.LatLng(19.3, -140.8),
        new google.maps.LatLng(55.65, -56.3));

    // The photograph is courtesy of the U.S. Geological Survey.
    var srcImage = 'http://maps.aerisapi.com/bNHMxIhgAvTKFIHWMM4by_5imlHk1xmnr9gnNU1AQUUn6meH9RSvjGWdFOWrLM/radar/1920x1080/lebanon,ks,5/0.png';

    overlay = new WeatherOverlay(bounds, srcImage, map);

    // Create the legend and display on the map
    var legendDiv = document.createElement('DIV');
    var legendDiv2 = document.createElement('DIV');
    var legend = new Legend(legendDiv, map);
    var legend2 = new PolicyLegend(legendDiv2, map);
    legendDiv.index = 1;
    map.controls[google.maps.ControlPosition.RIGHT_TOP].push(legendDiv);
    legendDiv2.index = 1;
    map.controls[google.maps.ControlPosition.LEFT_BOTTOM].push(legendDiv2);


    var drawingManager = new google.maps.drawing.DrawingManager({
        drawingMode: google.maps.drawing.OverlayType.MARKER,
        drawingControl: true,
        drawingControlOptions: {
            position: google.maps.ControlPosition.TOP_CENTER,
            drawingModes: [google.maps.drawing.OverlayType.POLYGON]
        },
        polygonOptions: {
            editable: true
        }
    });

    drawingManager.setMap(map);

    google.maps.event.addListener(drawingManager, "overlaycomplete", function(event) {
        var newShape = event.overlay;
        newShape.type = event.type;
    });

    google.maps.event.addDomListener(drawingManager, 'polygoncomplete', function(polygon) {
        google.maps.event.addListener(polygon.getPath(), 'set_at', function() {
            //alert("Changed");
            pushToPolyPoints(polygon);
            center_policies();
        });
        google.maps.event.addListener(polygon.getPath(), 'insert_at', function() {
            //("Inserted");
            pushToPolyPoints(polygon);
            center_policies();
        });
        pushToPolyPoints(polygon);
        center_policies();
    });

    google.maps.event.addDomListener(drawingManager, 'polylinecomplete', function(polygon) {
    });

}

/**
 *
 * Polygon Creation And Reconstruction
 * adds edges to polyPoints array to be used
 * for determining if address is within bounds
 * of Disaster Data Set
 *
 * @constructor
 *
 * */
function pushToPolyPoints(polygon){
    polyPoints = [];
    var polygonBounds = polygon.getPath();
    var xy;
    // Iterate over the polygonBounds vertices.

    for (var i = 0; i < polygonBounds.length; i++) {
        xy = polygonBounds.getAt(i);
        var points = {};
        points["lat"] = xy.lat();
        points["lng"] = xy.lng();
        polyPoints.push(points);
    }
}


/**
 *
 * If Disaster exists it retrieves the edge
 * point from database and calls to have it drawn on Map
 * @constructor
 *
 * */

function displayDisasterPolygon(map){
    var type = document.getElementById('type').value;
    var d_id = document.getElementById('d_id').value;
    if(type != "new"){
        var new_url = "/ajax/mapAjax.php?disaster="+type;
        if(d_id != -1){
            new_url = new_url+"&d_id="+d_id;
        }
        $.ajax({url: new_url, success: function(result){
            var new_array = [];
            var temp = JSON.parse(result);
            //alert(temp['properties']);
            disaster = temp["disaster"];
            var points = [];
            for(var point in disaster["polygon"]){
                points.push(disaster["polygon"][point]);
            }
            var disasterPoly = new google.maps.Polygon({
                paths: points,
                editable: true
            });
            disasterPoly.setMap(map);

            pushToPolyPoints(disasterPoly);
            center_policies();

            google.maps.event.addListener(disasterPoly.getPath(), 'set_at', function() {
                //alert("Changed");
                pushToPolyPoints(disasterPoly);
                center_policies();
            });
            google.maps.event.addListener(disasterPoly.getPath(), 'insert_at', function() {
                //alert("Inserted");
                pushToPolyPoints(disasterPoly);
                center_policies();
            });

        }});
    }
}

/**
 *
 * Weather Overlay Creation
 * Calls to http://maps.aerisapi.com
 * using  client id = 'bNHMxIhgAvTKFIHWMM4by'
 * and client key = '5imlHk1xmnr9gnNU1AQUUn6meH9RSvjGWdFOWrLM'
 *
 * Has the capability to decide style and time frame
 * @param bounds
 * @param image
 * @param map
 * @constructor
 *
 * */
function WeatherOverlay(bounds, image, map) {

    // Now initialize all properties.
    this.bounds_ = bounds;
    this.image_ = image;
    this.map_ = map;

    // Define a property to hold the image's div. We'll
    // actually create this div upon receipt of the onAdd()
    // method so we'll leave it null for now.
    this.div_ = null;

    // Explicitly call setMap on this overlay
    this.setMap(map);
}

/**
 *
 * Weather Overlay Creation
 * Add overlay
 *
 * */
WeatherOverlay.prototype.onAdd = function() {

    var div = document.createElement('div');
    div.style.border = 'none';
    div.style.borderWidth = '0px';
    div.style.position = 'absolute';

    // Create the img element and attach it to the div.
    var img = document.createElement('img');
    img.src = this.image_;
    img.style.width = '100%';
    img.style.height = '100%';
    div.appendChild(img);

    this.div_ = div;
    this.div_.style.opacity = 0.6;

    // Add the element to the "overlayImage" pane.
    var panes = this.getPanes();
    panes.overlayImage.appendChild(this.div_);
};


/**
 *
 * Weather Overlay Creation
 * draws overlay
 *
 * */
WeatherOverlay.prototype.draw = function() {

    // We use the south-west and north-east
    // coordinates of the overlay to peg it to the correct position and size.
    // To do this, we need to retrieve the projection from the overlay.
    var overlayProjection = this.getProjection();

    // Retrieve the south-west and north-east coordinates of this overlay
    // in LatLngs and convert them to pixel coordinates.
    // We'll use these coordinates to resize the div.
    var sw = overlayProjection.fromLatLngToDivPixel(this.bounds_.getSouthWest());
    var ne = overlayProjection.fromLatLngToDivPixel(this.bounds_.getNorthEast());

    // Resize the image's div to fit the indicated dimensions.
    var div = this.div_;
    div.style.left = sw.x + 'px';
    div.style.top = ne.y + 'px';
    div.style.width = (ne.x - sw.x) + 'px';
    div.style.height = (sw.y - ne.y) + 'px';
};

/**
 *
 * Weather Overlay Creation
 * Remove overlay
 *
 * */
WeatherOverlay.prototype.onRemove = function() {
    this.div_.parentNode.removeChild(this.div_);
};


/**
 *
 * Weather Overlay Creation
 * Set overlay hidden
 *
 * */
WeatherOverlay.prototype.hide = function() {
    if (this.div_) {
        // The visibility property must be a string enclosed in quotes.
        this.div_.style.visibility = 'hidden';
    }
};


/**
 *
 * Weather Overlay Creation
 * Set overlay visible
 *
 * */
WeatherOverlay.prototype.show = function() {
    if (this.div_) {
        this.div_.style.visibility = 'visible';
    }
};

/**
 *
 * Weather Overlay Creation
 * Toggle overlay visible/hidden
 *
 * */
WeatherOverlay.prototype.toggle = function() {
    if (this.div_) {
        if (this.div_.style.visibility === 'hidden') {
            this.show();
        } else {
            this.hide();
        }
    }
};


/**
 *
 * Weather Overlay Creation
 * Set overlay time frame to display
 * and style of map.
 * Used for looking at past weather events
 *
 * */
WeatherOverlay.prototype.time = function() {
    this.setMap(null);
    var style = document.getElementById('style').value;
    if(style != "None") {
        var start = document.getElementById('startTime').value;
        start = start.replace(/-/g, "");
        start = start.replace(/T/g, "");
        start = start.replace(/:/g, "");


        var srcImage = 'http://maps.aerisapi.com/bNHMxIhgAvTKFIHWMM4by_5imlHk1xmnr9gnNU1AQUUn6meH9RSvjGWdFOWrLM/' + style + '/1920x1080/lebanon,ks,5/' + start + '00.png';

        //console.log(srcImage);
        overlay = new WeatherOverlay(bounds, srcImage, map);
    }



};

google.maps.event.addDomListener(window, 'load', initMap);

/**
*
 *          Creation of Marker Arrays to build Cluster of Map Markers.
 *
 *            Function to Pull Policy Holders address from database
 *           If the address is not linked to a lat and lon one will be created by
 *           sending to geocodeAddress() to acquire lat and lon.
 *
 *           Once pulled it is parsed sets a map Marker and sends it to correct
 *           Cluster Array(New,  Assigned, Closed, No).  that controls the Visual display
 *           Of each category of markers
 *
 *           Final step of creation is pushing the (id,P_ID,lat,lng,size) into a
 *           propPoints array to allow filtering and sorting
*
 *  @param geocoder
 * @param map
 * @constructor
*
 */
function address(geocoder, map){
    var type = document.getElementById('type').value;
    var d_id = document.getElementById('d_id').value;

    var latlng;
    var prop;
    var status = -1;
    var new_string = "";

    var new_url = "/ajax/mapAjax.php?disaster="+type+"&personal"+"&business";
    //var pers_url = "/ajax/mapAjax.php?personal="+type;
    //var bus_url = "/ajax/mapAjax.php?business="+type;
    if(d_id != -1){
        new_url = new_url+"&d_id="+d_id;
    }
    $.ajax({url: new_url, success: function(result){
        var temp = JSON.parse(result);
        //console.log("entering");
        for(var i = 0; i < temp['properties'].length; i++) {
            if (temp['claims'] != null) {
                if (temp['properties'][i]['lat'] != 0) {
                    status = -1;
                    for (var j = 0; j < temp['claims'].length; j++) {
                        if (temp['properties'][i]['id'] == temp['claims'][j]['id']) {
                            status = temp['claims'][j]['status'];
                        }
                    }
                    latLng = {
                        lat: temp['properties'][i]['lat'],
                        lng: temp['properties'][i]['lng']
                    };
                    //console.log(temp['properties'][i]);
                    addMarker(latLng, status);
                    var prop = {
                        id: temp['properties'][i]['id'],
                        P_ID: temp['properties'][i]['P_ID'],
                        lat: temp['properties'][i]['lat'],
                        lng: temp['properties'][i]['lng'],
                        size: temp['properties'][i]['size'],
                        status: status
                    };
                    propPoints.push(prop);

                }
                else {
                    status = -1;
                    for (var k = 0; k < temp['claims'].length; k++) {
                        if (temp['properties'][i]['id'] == temp['claims'][k]['id']) {
                            status = temp['claims'][k]['status'];
                        }
                    }

                    new_string = "";
                    new_string += temp['properties'][i]['address'];
                    new_string += ",";
                    new_string += temp['properties'][i]['city'];
                    new_string += ",";
                    new_string += temp['properties'][i]['state'];
                    new_string += " ";
                    new_string += temp['properties'][i]['zipCode'];

                    geocodeAddress(geocoder, map, new_string, temp['properties'][i]['id'], temp['properties'][i]['P_ID'], temp['properties'][i]['size'], status);
                }
            }
            else{
                status = -1;
                if(temp['properties'][i]['lat'] != 0){
                    status = -1;
                    latLng = {
                        lat: temp['properties'][i]['lat'],
                        lng: temp['properties'][i]['lng']
                    };
                    addMarker(latLng, status);
                    var prop = {
                        id: temp['properties'][i]['id'],
                        P_ID: temp['properties'][i]['P_ID'],
                        lat: temp['properties'][i]['lat'],
                        lng: temp['properties'][i]['lng'],
                        size: temp['properties'][i]['size'],
                        status: status
                    };
                    propPoints.push(prop);
                }
                else {
                    new_string = "";
                    new_string += temp['properties'][i]['address'];
                    new_string += ",";
                    new_string += temp['properties'][i]['city'];
                    new_string += ",";
                    new_string += temp['properties'][i]['state'];
                    new_string += " ";
                    new_string += temp['properties'][i]['zipCode'];

                    geocodeAddress(geocoder, map, new_string, temp['properties'][i]['id'], temp['properties'][i]['P_ID'], temp['properties'][i]['size'], status);
                }
            }
        }

        //console.log("exiting");
        var clusterNo = [{textColor: 'black', url: 'img/blue1.png', height: 60, width: 35, anchor: [10, 5]}];
        var clusterNew = [{textColor: 'black', url: 'img/red1.png', height: 60, width: 35, anchor: [10, 5]}];
        var clusterAssigned = [{textColor: 'black', url: 'img/orange1.png', height: 60, width: 35, anchor: [10, 5]}];
        var clusterClosed = [{textColor: 'black', url: 'img/green1.png', height: 60, width: 35, anchor: [10, 5]}];

        var mcOptionsNo = {gridSize: 50, maxZoom: 15, zoomOnClick: true, minimumClusterSize: 2, averageCenter: true, styles: clusterNo};
        var mcOptionsNew = {gridSize: 50, maxZoom: 15, zoomOnClick: true, minimumClusterSize: 2, averageCenter: true,styles: clusterNew};
        var mcOptionsAssigned = {gridSize: 50, maxZoom: 15, zoomOnClick: true, minimumClusterSize: 2, averageCenter: true,styles: clusterAssigned};
        var mcOptionsClosed = {gridSize: 50, maxZoom: 15, zoomOnClick: true, minimumClusterSize: 2, averageCenter: true, styles: clusterClosed};
        markerClusterNo = new MarkerClusterer(map, NoClaimMarkers, mcOptionsNo);
        markerClusterNew = new MarkerClusterer(map, NewClaimMarkers, mcOptionsNew);
        markerClusterAssigned = new MarkerClusterer(map, AssignedClaimMarkers, mcOptionsAssigned);
        markerClusterClosed = new MarkerClusterer(map, ClosedClaimMarkers, mcOptionsClosed);

        //console.log("clustered");
    }});


}

/**
 * Uses Google map API geocoder to transfer a address string into a latitude and longitude
 * for map marker placement
 *
 * @param geocoder
 * @param resultsMap
 * @param new_string
 * @param id
 * @param p_id
 * @param size
 * @param status
 */
function geocodeAddress(geocoder, resultsMap, new_string, id, p_id, size, status) {

    geocoder.geocode({'address': new_string}, function(results, status) {

        if (status === google.maps.GeocoderStatus.OK) {

            var prop = {
                id: id,
                P_ID: p_id,
                lat: results[0].geometry.location.lat(),
                lng: results[0].geometry.location.lng(),
                size: size
            };
            propPoints.push(prop);


            var latLng = {lat: results[0].geometry.location.lat(),
                lng: results[0].geometry.location.lng()};

            addMarker(latLng);


            $.post( "ajax/mapAjax.php", {update: 'true', id: id, P_ID: p_id, lat: results[0].geometry.location.lat(), lng: results[0].geometry.location.lng()})
                .done(function(data){
                });


        } else {
            alert('Geocode was not successful for the following reason: ' + status);
        }

    });
}

/**
 *
 *      Algorithms and Calls to Markers and Clusters of Markers
 *      Algorithms for filtering through Markers and marker Clusters
 *
 */





/**
 * Filtering out different style claims
 *
 * Checks to see all filters selected on Map Page
 * Splitting into different categories for each Marker Cluster array
 *
 * Setting Marker Cluster array to empty then it the adds markers
 * that are included in selected flters back onto the map and into the array
 *
 *
 *
 */
function markerFilter() {
    var status;
    if(!(document.getElementById('NoClaim').checked)) {
        markerClusterNo.clearMarkers(NoClaimMarkers);
    }

    if(!(document.getElementById('NewClaim').checked)) {
        markerClusterNew.clearMarkers(NewClaimMarkers);
    }

    if(!(document.getElementById('AssignedClaim').checked)) {
        markerClusterAssigned.clearMarkers(AssignedClaimMarkers);
    }

    if(!(document.getElementById('ClosedClaim').checked)) {
        markerClusterClosed.clearMarkers(ClosedClaimMarkers);
    }
    if((document.getElementById('NoClaim').checked)) {
        markerClusterNo.clearMarkers(NoClaimMarkers);
        NoClaimMarkers = [];
        status = -1;
        indMarkerFilter(status, NoClaimMarkers);
        markerClusterNo.addMarkers(NoClaimMarkers);
    }

    if((document.getElementById('NewClaim').checked)) {
        markerClusterNew.clearMarkers(NewClaimMarkers);
        NewClaimMarkers = [];
        status = 0;
        indMarkerFilter(status, NewClaimMarkers);
        markerClusterNew.addMarkers(NewClaimMarkers);
    }

    if((document.getElementById('AssignedClaim').checked)) {
        markerClusterAssigned.clearMarkers(AssignedClaimMarkers);
        AssignedClaimMarkers = [];
        status = 1;
        indMarkerFilter(status, AssignedClaimMarkers);
        markerClusterAssigned.addMarkers(AssignedClaimMarkers);
    }

    if((document.getElementById('ClosedClaim').checked)) {
        markerClusterClosed.clearMarkers(ClosedClaimMarkers);
        ClosedClaimMarkers = [];
        status = 2;
        indMarkerFilter(status);
        markerClusterClosed.addMarkers(ClosedClaimMarkers);
    }
}
/**
 * Filtering out size claims for each Marker Cluster Array
 * @param status
 */
function indMarkerFilter(status){

    for(var i = 0; i < propPoints.length; i++) {
        if (document.getElementById('Size-0').checked) {
            if (propPoints[i]['size'] > 0 && propPoints[i]['size'] <= 20000 && propPoints[i]['status'] == status) {
                addMarker({lat: propPoints[i]['lat'], lng: propPoints[i]['lng']}, propPoints[i]['status']);
            }
        }

        if (document.getElementById('Size-20').checked) {
            if (propPoints[i]['size'] > 20000 && propPoints[i]['size'] <= 50000 && propPoints[i]['status'] == status) {
                addMarker({lat: propPoints[i]['lat'], lng: propPoints[i]['lng']}, propPoints[i]['status']);
            }
        }

        if (document.getElementById('Size-50').checked) {
            if (propPoints[i]['size'] > 50000 && propPoints[i]['size'] <= 100000 && propPoints[i]['status'] == status) {
                addMarker({lat: propPoints[i]['lat'], lng: propPoints[i]['lng']}, propPoints[i]['status']);
            }
        }

        if (document.getElementById('Size-100').checked) {
            if (propPoints[i]['size'] > 100000 && propPoints[i]['size'] <= 150000 && propPoints[i]['status'] == status) {
                addMarker({lat: propPoints[i]['lat'], lng: propPoints[i]['lng']}, propPoints[i]['status']);
            }
        }

        if (document.getElementById('Size-150').checked) {
            if (propPoints[i]['size'] > 150000 && propPoints[i]['size'] <= 250000&& propPoints[i]['status'] == status) {
                addMarker({lat: propPoints[i]['lat'], lng: propPoints[i]['lng']}, propPoints[i]['status']);
            }
        }

        if (document.getElementById('Size-250').checked) {
            if (propPoints[i]['size'] > 250000 && propPoints[i]['size'] <= 500000 && propPoints[i]['status'] == status) {
                addMarker({lat: propPoints[i]['lat'], lng: propPoints[i]['lng']}, propPoints[i]['status']);
            }
        }

        if (document.getElementById('Size-500').checked) {
            if (propPoints[i]['size'] > 500000 && propPoints[i]['status'] == status) {
                addMarker({lat: propPoints[i]['lat'], lng: propPoints[i]['lng']}, propPoints[i]['status']);
            }
        }
    }

}

/**
 *
 * Adds a marker to the map and push to the array.
 * Lat,lng and status supplied from address()
 *
 * @param location
 * @param status
 * @constructor
 **/

 function addMarker(location, status) {
    var marker;
    var NoClaimMarker = {url: 'img/blue.png'};
    var NewClaimMarker = {url: 'img/red.png'};
    var AssignedClaimMarker ={url: 'img/orange.png'};
    var ClosedClaimMarker ={url: 'img/green.png'};
    var pin = NoClaimMarker;
    if(status === 0){
        marker = new google.maps.Marker({
            icon: NewClaimMarker,
            position: location,
            map: map
        });
        //NoClaimMarkers.push(marker);
        NewClaimMarkers.push(marker);
    }
    else if(status === 1){
        marker = new google.maps.Marker({
            icon: AssignedClaimMarker,
            position: location,
            map: map
        });
        //NoClaimMarkers.push(marker);
        AssignedClaimMarkers.push(marker);
    }
    else if(status === 2){
        marker = new google.maps.Marker({
            icon: ClosedClaimMarker,
            position: location,
            map: map
        });
        //NoClaimMarkers.push(marker);
        ClosedClaimMarkers.push(marker);
    }

    else if(status === -1) {
        marker = new google.maps.Marker({
            icon: pin,
            position: location,
            map: map
        });
        NoClaimMarkers.push(marker);
    }
}

// Sets the map on all markers in the array.
function setMapOnAll(map) {
    for (var i = 0; i < NoClaimMarkers.length; i++) {
        NoClaimMarkers[i].setMap(map);
    }
    for (var j = 0; j < NewClaimMarkers.length; j++) {
        NewClaimMarkers[j].setMap(map);
    }
    for (var k = 0; k < AssignedClaimMarkers.length; k++) {
        AssignedClaimMarkers[k].setMap(map);
    }
    for (var l = 0; l < ClosedClaimMarkers.length; l++) {
        ClosedClaimMarkers[l].setMap(map);
    }

}


/**
 *  Clears Markers on Map but does not remove from Cluster Markers
 */
// Removes the markers from the map, but keeps them in the array.
function clearMarkers() {
    setMapOnAll(null);
}


// Deletes all markers in the array by removing references to them.
function deleteMarkers() {
    NoClaimMarkers = [];
    NewClaimMarkers = [];
    AssignedClaimMarkers = [];
    ClosedClaimMarkers = [];
    clearMarkers();
}
/**
*   Map Legend Display
*   Functions
*
 **/


/**
 * Sets the Weather Overlay Legends on Google Map
 * in Upper right Corner
 *
 * @param controlDiv
 * @param map
 * @constructor
 */
function Legend(controlDiv, map) {
    // Set CSS styles for the DIV containing the control
    // Setting padding to 5 px will offset the control
    // from the edge of the map
    controlDiv.style.padding = '5px';

    // Set CSS for the control border
    var controlUI = document.createElement('DIV');
    controlUI.style.backgroundColor = 'black';
    controlUI.style.borderStyle = 'solid';
    controlUI.style.borderWidth = '1px';
    controlUI.title = 'Legend';
    controlDiv.appendChild(controlUI);

    // Set CSS for the control text
    var controlText = document.createElement('DIV');


    // Add the text
    controlText.innerHTML = '<img src="img/radar.png" /><br/><br/>' +
        '<img src="img/advisories.png" />';

    controlUI.appendChild(controlText);
}

/**
 * Sets Address marker Legend to distinguish between Claims Status
 * on bottom left of map
 *
 * @param controlDiv
 * @param map
 * @constructor
 */

function PolicyLegend(controlDiv, map) {
    // Set CSS styles for the DIV containing the control
    // Setting padding to 5 px will offset the control
    // from the edge of the map
    controlDiv.style.padding = '5px';

    // Set CSS for the control border
    var controlUI = document.createElement('DIV');
    controlUI.style.backgroundColor = 'white';
    controlUI.style.borderStyle = 'solid';
    controlUI.style.borderWidth = '1px';
    controlUI.title = 'Legend';
    controlDiv.appendChild(controlUI);

    // Set CSS for the control text
    var controlText = document.createElement('DIV');
    controlText.style.paddingLeft = '4px';
    controlText.style.paddingRight = '4px';

    // Add the text
    controlText.innerHTML = '<h6>Policy Key</h6>' +
        '<div class="box1"></div><div class="boxTitle1">No Claim</div><br />' +
        '<div class="box2"></div><div class="boxTitle2">New Claim</div><br />' +
        '<div class="box3"></div><div class="boxTitle3">Assigned Claim</div><br />' +
        '<div class="box4"></div><div class="boxTitle4">Closed Claim</div><br /><br />';


    controlUI.appendChild(controlText);
}

