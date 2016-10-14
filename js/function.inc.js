/**
 * Created by cse498 on 1/28/16.
 */
var polyPoints = [];
var propPoints = [];
var usedPoints= [];
dPoints = [];
var bound = new google.maps.LatLngBounds();
var centerMarker = new google.maps.Marker();
var north = 0;
var south = 90;
var east = -180;
var west = 0;

/**
 * saves the new disaster information to the database and
 * the points in the polygon to the disaster dataset
 */
function save_click() {
    var points = [];
    var name = document.getElementById('disaster_name').value;
    var city = document.getElementById('disaster_city').value;
    var state = document.getElementById('disaster_state').value;
    var date = document.getElementById('disaster_date').value;
    var reason = document.getElementById('disaster_reason').value;
    var error = document.getElementById('error');

    //alert(reason);
    if (name == "" || city == "" || date == "") {

        error.innerHTML = "Please Fill In Form Completely!";

    }

    else {

        var result = JSON.stringify(polyPoints);
        var start = new Date().getTime();

        var Policies = sort_policies();
        $.post("ajax/saveAjax.php", {
                name: name,
                date: date,
                city: city,
                state: state,
                polygon: result,
                reason: reason,
                properties: Policies

            })
            .done(function (data) {
                //console.log(data);
                location.reload();
            });

    }

}

/**
 * updates the disaster polygon in the database and
 * updates the disaster dataset with the new points in the polygon.
 */
function update_click(){
    var id = document.getElementById('d_id').value;
    var result = JSON.stringify(polyPoints);

    var Policies = sort_policies();
    console.log("starting Post");
    $.post("ajax/saveAjax.php", {id:id, polygon: result, properties: Policies})
        .done(function(data){
            //console.log(data);
            location.reload();
        });
}

function sort_policies() {
    console.log("starting loop");
    for(var i = 0; i < propPoints.length; i++) {
        var Position = new google.maps.LatLng(propPoints[i]['lat'],propPoints[i]['lng']);
        var Polygon = new google.maps.Polygon({
            paths: polyPoints
        });
        if(google.maps.geometry.poly.containsLocation(Position, Polygon)) {

            var prop = {
                id: propPoints[i]['id'],
                P_ID: propPoints[i]['P_ID']

            };
            usedPoints.push(prop);
        }
    }
    console.log(usedPoints.length);
    console.log(propPoints.length);
    //var Policies = JSON.stringify(usedPoints);
    return JSON.stringify(usedPoints);
}

/**
 * function to generate the html required to change the policy modal
 * for each policy clicked on in the policy page
 * @param prop_id
 */
function displayPolicyModal(prop_id){
    $(".policy").remove();
    $.get("/ajax/policyAjax.php?prop_id="+prop_id, function(json){
        //console.log(json);
        var obj = JSON.parse(json);
        //console.log(obj);
        var ph = obj['policyHolder'];
        var p = obj['policy'];
        var a = obj['agency'];
        var prop = obj['property'];
        var pcs = obj['personalClaims'];
        var bcs = obj['businessClaims'];

        document.getElementById('phName').textContent = ph['firstName'] + " "+ ph['lastName'];
        document.getElementById('ph_name').textContent = ph['firstName'] + " "+ ph['lastName'];
        document.getElementById('ph_address').textContent = ph['address'] + ", " + ph['city'] + ", " + ph['state'] + " " + ph['zipCode'];
        //document.getElementById('ph_address2').textContent = ph['city'] + ", " + ph['state'] + " " + ph['zipCode'];

        if(ph['primPhoneNumber'] != ""){
            var phoneNum = '(';
            phoneNum += ph['primPhoneNumber'].substr(0,3) + ') ';
            phoneNum += ph['primPhoneNumber'].substr(3,3) + ' - ' + ph['primPhoneNumber'].substr(6,4);
            document.getElementById('ph_prim_phone').textContent = phoneNum;
        }
        else{
            document.getElementById('ph_prim_phone').textContent = ph['primPhoneNumber'];
        }

        if(ph['secPhoneNumber'] != ""){
            var phoneNum = '(';
            phoneNum += ph['secPhoneNumber'].substr(0,2) + ') ';
            phoneNum += ph['secPhoneNumber'].substr(3,5) + ' - ' + ph['secPhoneNumber'].substr(6,9);
            document.getElementById('ph_sec_phone').textContent = phoneNum;
        }
        else{
            document.getElementById('ph_sec_phone').textContent = ph['secPhoneNumber'];
        }

        document.getElementById('policy_start').textContent = p['coverageStart'].substr(5,10)+"-"+p['coverageStart'].substr(0,4);
        document.getElementById('policy_end').textContent = p['coverageStop'].substr(5,10)+"-"+p['coverageStop'].substr(0,4);

        if(p['policyType'] == 0){
            document.getElementById('policy_type').textContent = 'Business Policy';
        }
        else {
            document.getElementById('policy_type').textContent = 'Personal Policy';
        }

        document.getElementById('agency_name').textContent = a['name'];
        document.getElementById('agency_address').textContent = a['address'] + ", " + a['city'] + ", " + a['state'] + " " + a['zipCode'];
        //document.getElementById('agency_address2').textContent = a['city'] + ", " + a['state'] + " " + a['zipCode'];

        document.getElementById('prop_address').textContent = prop['address'] + ", " + prop['city'] + ", " + prop['state'] + " " + prop['zipCode'];
        //document.getElementById('prop_address2').textContent = prop['city'] + ", " + prop['state'] + " " + prop['zipCode'];

        if(prop['propType'] == 0){
            document.getElementById('prop_type').textContent = 'Business Property';
        }
        else {
            document.getElementById('prop_type').textContent = 'Personal Property';
        }

        //document.getElementById('prop_size').textContent = "$" + prop['size'];
        var size = '';
        if(prop['size'] <= 999){
            document.getElementById('prop_size').textContent = "$" + prop['size'];
        }
        else if(prop['size'] > 999 && prop['size'] < 9999){
            size += '$' + prop['size'].toString().substr(0,1) + ',' +prop['size'].toString().substr(1,3);
        }
        else if(prop['size'] > 9999 && prop['size'] < 99999){
            size += '$' + prop['size'].toString().substr(0,2) + ',' +prop['size'].toString().substr(2,3);
        }
        else if(prop['size'] > 99999 && prop['size'] < 999999){
            console.log("here");
            size += '$' + prop['size'].toString().substr(0,3) + ',' +prop['size'].toString().substr(3,3);
        }
        else if(prop['size'] > 999999 && prop['size'] < 9999999){
            size += '$' + prop['size'].toString().substr(0,1) + ',' +prop['size'].toString().substr(1,3) + ',' + prop['size'].toString().substr(4,3);
        }
        else if(prop['size'] > 9999999 && prop['size'] < 99999999){
            size += '$' + prop['size'].toString().substr(0,2) + ',' +prop['size'].toString().substr(2,3) + ',' + prop['size'].toString().substr(5,3);
        }
        console.log(size);

        document.getElementById('prop_size').textContent = size;

        $(".perClaim").remove();
        $(".busClaim").remove();
        //$("#personal").append("<div class='panel-heading'><big><b>Personal Claims</b></big></div><div class='panel-body'>");

        var html = "";

        if (prop['propType'] == 1) {
            //PERSONAL CLAIMS
            for(var i in pcs){
                if(i == 0){
                    html+="<div class='panel-heading perClaim' id='policyHolderHeading'><big><b>Personal Claims</b></big></div><div class='panel-body perClaim'>";
                }
                html+="<div class=\"perClaim\"><h4>Personal Claim #"+ pcs[i]['id'] +"</h4><hr id='nameHR'>";
                html+="<form action=\"post/policy-post.php\" method=\"post\">";

                //html+="<div class='container-fluid'>";
                //html+="<p style='float: left;'><b>Disaster:</b></p> <input id='policyHolderText' style='float: right; text-align: right;' type=\"text\" name=\"d_id\" value=\"" + pcs[i]['D_ID'] + "\"></div>";

                html+="<div class='container-fluid'>";
                html+="<p style='float: left;'><b>Content Damage:</b></p>" //<input style='float: right; text-align: right;' type=\"text\" name=\"contentDamage\" value=\"" + pcs[i]['contentDamage'] + "\"></div>";
                html+="<select  style='float: right; text-align: right;' class='form-control' name='contentDamage' id='policyHolderDropDown' >";

                if(pcs[i]['contentDamage'] == 0){
                    html+="<option value='0' selected>None</option>";
                    html+="<option value='1'>Light</option>";
                    html+="<option value='2'>Medium</option>";
                    html+="<option value='3'>Heavy</option>";
                    html+="<option value='4'>Total Loss</option>";
                    html+="</select></div>";
                }
                else if(pcs[i]['contentDamage'] == 1){
                    html+="<option value='0'>None</option>";
                    html+="<option value='1' selected>Light</option>";
                    html+="<option value='2'>Medium</option>";
                    html+="<option value='3'>Heavy</option>";
                    html+="<option value='4'>Total Loss</option>";
                    html+="</select></div>";
                }
                else if(pcs[i]['contentDamage'] == 2){
                    html+="<option value='0'>None</option>";
                    html+="<option value='1'>Light</option>";
                    html+="<option value='2' selected>Medium</option>";
                    html+="<option value='3'>Heavy</option>";
                    html+="<option value='4'>Total Loss</option>";
                    html+="</select></div>";
                }
                else if(pcs[i]['contentDamage'] == 3){
                    html+="<option value='0'>None</option>";
                    html+="<option value='1'>Light</option>";
                    html+="<option value='2'>Medium</option>";
                    html+="<option value='3' selected>Heavy</option>";
                    html+="<option value='4'>Total Loss</option>";
                    html+="</select></div>";
                }
                else if(pcs[i]['contentDamage'] == 4){
                    html+="<option value='0'>None</option>";
                    html+="<option value='1'>Light</option>";
                    html+="<option value='2'>Medium</option>";
                    html+="<option value='3'>Heavy</option>";
                    html+="<option value='4' selected>Total Loss</option>";
                    html+="</select></div>";
                }

                html+="<div class='container-fluid'>";
                html+="<p style='float: left;'><b>Dwelling Damage:</b></p>" //<input style='float: right; text-align: right;' type=\"text\" name=\"dwellingDamage\" value=\"" + pcs[i]['dwellingDamage'] + "\"></div>";
                html+="<select  style='float: right; text-align: right;' class='form-control' name='dwellingDamage' id='policyHolderDropDown' >";

                if(pcs[i]['dwellingDamage'] == 0){
                    html+="<option value='0' selected>None</option>";
                    html+="<option value='1'>Light</option>";
                    html+="<option value='2'>Medium</option>";
                    html+="<option value='3'>Heavy</option>";
                    html+="<option value='4'>Total Loss</option>";
                    html+="</select></div>";
                }
                else if(pcs[i]['dwellingDamage'] == 1){
                    html+="<option value='0'>None</option>";
                    html+="<option value='1' selected>Light</option>";
                    html+="<option value='2'>Medium</option>";
                    html+="<option value='3'>Heavy</option>";
                    html+="<option value='4'>Total Loss</option>";
                    html+="</select></div>";
                }
                else if(pcs[i]['dwellingDamage'] == 2){
                    html+="<option value='0'>None</option>";
                    html+="<option value='1'>Light</option>";
                    html+="<option value='2' selected>Medium</option>";
                    html+="<option value='3'>Heavy</option>";
                    html+="<option value='4'>Total Loss</option>";
                    html+="</select></div>";
                }
                else if(pcs[i]['dwellingDamage'] == 3){
                    html+="<option value='0'>None</option>";
                    html+="<option value='1'>Light</option>";
                    html+="<option value='2'>Medium</option>";
                    html+="<option value='3' selected>Heavy</option>";
                    html+="<option value='4'>Total Loss</option>";
                    html+="</select></div>";
                }
                else if(pcs[i]['dwellingDamage'] == 4){
                    html+="<option value='0'>None</option>";
                    html+="<option value='1'>Light</option>";
                    html+="<option value='2'>Medium</option>";
                    html+="<option value='3'>Heavy</option>";
                    html+="<option value='4' selected>Total Loss</option>";
                    html+="</select></div>";
                }

                html+="<div class='container-fluid'>";
                html+="<p style='float: left;'><b>Other Damage:</b></p>" //<input style='float: right; text-align: right;' type=\"text\" name=\"otherDamage\" value=\"" + pcs[i]['otherDamage'] + "\"></div>";
                html+="<select  style='float: right; text-align: right;' class='form-control' name='otherDamage' id='policyHolderDropDown' >";

                if(pcs[i]['otherDamage'] == 0){
                    html+="<option value='0' selected>None</option>";
                    html+="<option value='1'>Light</option>";
                    html+="<option value='2'>Medium</option>";
                    html+="<option value='3'>Heavy</option>";
                    html+="<option value='4'>Total Loss</option>";
                    html+="</select></div>";
                }
                else if(pcs[i]['otherDamage'] == 1){
                    html+="<option value='0'>None</option>";
                    html+="<option value='1' selected>Light</option>";
                    html+="<option value='2'>Medium</option>";
                    html+="<option value='3'>Heavy</option>";
                    html+="<option value='4'>Total Loss</option>";
                    html+="</select></div>";
                }
                else if(pcs[i]['otherDamage'] == 2){
                    html+="<option value='0'>None</option>";
                    html+="<option value='1'>Light</option>";
                    html+="<option value='2' selected>Medium</option>";
                    html+="<option value='3'>Heavy</option>";
                    html+="<option value='4'>Total Loss</option>";
                    html+="</select></div>";
                }
                else if(pcs[i]['otherDamage'] == 3){
                    html+="<option value='0'>None</option>";
                    html+="<option value='1'>Light</option>";
                    html+="<option value='2'>Medium</option>";
                    html+="<option value='3' selected>Heavy</option>";
                    html+="<option value='4'>Total Loss</option>";
                    html+="</select></div>";
                }
                else if(pcs[i]['otherDamage'] == 4){
                    html+="<option value='0'>None</option>";
                    html+="<option value='1'>Light</option>";
                    html+="<option value='2'>Medium</option>";
                    html+="<option value='3'>Heavy</option>";
                    html+="<option value='4' selected>Total Loss</option>";
                    html+="</select></div>";
                }

                html+="<div class='container-fluid'>";
                html+="<p style='float: left;'><b>Flood Insurance:</b></p>" //<input id='policyHolderText' style='float: right; text-align: right;'type=\"text\" name=\"floodInsurance\" value=\"" + pcs[i]['floodInsurance'] + "\"></div>";
                html+="<select id='floodInsurance' style='float: right; text-align: right;' class='form-control' name='floodInsurance'>";

                if(pcs[i]['floodInsurance'] == 0){
                    html+="<option value='1'>Yes</option>";
                    html+="<option value='0' selected>No</option>";
                    html+="</select></div>";
                }
                else if(pcs[i]['floodInsurance'] == 1){
                    html+="<option value='1' selected>Yes</option>";
                    html+="<option value='0'>No</option>";
                    html+="</select></div>";
                }

                html+="<div class='container-fluid'>";
                html+="<p style='float: left;'><b>Flood Insurer:</b></p> <input id='policyHolderText' style='float: right; text-align: right;' type=\"text\" name=\"floodInsurer\" value=\"" + pcs[i]['floodInsurer'] + "\"></div>";

                html+="<div class='container-fluid'>";
                html+="<p style='float: left;'><b>Claims Adjuster:</b></p> <input id='policyHolderText' style='float: right; text-align: right;' type=\"text\" name=\"username\" value=\"" + pcs[i]['U_USERNAME'] + "\"></div>";

                html+="<div class='container-fluid'>";
                html+="<p style='float: left;'><b>Status:</b></p>" //<input style='float: right; text-align: right;' type=\"text\" name=\"status\" value=\"" + pcs[i]['status'] + "\"></div>";
                html+="<select  style='float: right; text-align: right;' class='form-control' name='status' id='policyHolderDropDown' >";

                if(pcs[i]['status'] == 0){
                    html+="<option value='0' selected>New Claim</option>";
                    html+="<option value='1'>Assigned Claim</option>";
                    html+="<option value='2'>Closed Claim</option>";
                    html+="</select></div>";
                }
                else if(pcs[i]['status'] == 1){
                    html+="<option value='0'>New Claim</option>";
                    html+="<option value='1' selected>Assigned Claim</option>";
                    html+="<option value='2'>Closed Claim</option>";
                    html+="</select></div>";
                }
                else if(pcs[i]['status'] == 2){
                    html+="<option value='0'>New Claim</option>";
                    html+="<option value='1'>Assigned Claim</option>";
                    html+="<option value='2' selected>Closed Claim</option>";
                    html+="</select></div>";
                }

                html+="<div class='container-fluid'>";
                html+="<p style='float: left;'><b>Date:</b></p> <input id='policyHolderText' style='float: right; text-align: right;' type=\"date\" name=\"date\" value=\"" + pcs[i]['date'] + "\"></div>";

                html+="<input type=\"hidden\" name=\"claim\" value=\""+ pcs[i]['id'] + "\">";
                html+="<input type=\"hidden\" name=\"type\" value=\"personal\">";
                html+="<input type=\"hidden\" name=\"d_id\" value=\""+ pcs[i]['D_ID'] + "\">";

                html+="<input type=\"Submit\" class='btn btn-primary' value=\"Save\"></p></form></div><br>";

                //$("#personal").append(html);
                //$(".modal-footer").before(html);
            }

            $("#personal").append(html+"</div></div>");

            $('#business').hide();
            $('#personal').show();
        }

        html = "";

        if (prop['propType'] == 0) {
            //BUSINESS CLAIMS
            for(var i in bcs){
                if(i == 0){
                    html+="<div class='panel-heading busClaim' id='policyHolderHeading'><big><b>Business Claims</b></big></div><div class='panel-body busClaim'>";
                }
                html+="<div class=\"busClaim\"><h4>Business Claim #"+ bcs[i]['id'] +"</h4><hr id='nameHR'>";
                html+="<form action=\"post/policy-post.php\" method=\"post\">";

                //html+="<div class='container-fluid'>";
                //html+="<p style='float: left;'><b>Disaster:</b></p> <input id='policyHolderText' style='float: right; text-align: right;' type=\"text\" name=\"d_id\" value=\"" + bcs[i]['D_ID'] + "\"></div>";

                html+="<div class='container-fluid'>";
                html+="<p style='float: left;'><b>Content Damage:</b></p>" //<input style='float: right; text-align: right;' type=\"text\" name=\"contentDamage\" value=\"" + bcs[i]['contentDamage'] + "\"></div>";
                html+="<select  style='float: right; text-align: right;' class='form-control' name='contentDamage' id='policyHolderDropDown' >";

                if(bcs[i]['contentDamage'] == 0){
                    html+="<option value='0' selected>None</option>";
                    html+="<option value='1'>Light</option>";
                    html+="<option value='2'>Medium</option>";
                    html+="<option value='3'>Heavy</option>";
                    html+="<option value='4'>Total Loss</option>";
                    html+="</select></div>";
                }
                else if(bcs[i]['contentDamage'] == 1){
                    html+="<option value='0'>None</option>";
                    html+="<option value='1' selected>Light</option>";
                    html+="<option value='2'>Medium</option>";
                    html+="<option value='3'>Heavy</option>";
                    html+="<option value='4'>Total Loss</option>";
                    html+="</select></div>";
                }
                else if(bcs[i]['contentDamage'] == 2){
                    html+="<option value='0'>None</option>";
                    html+="<option value='1'>Light</option>";
                    html+="<option value='2' selected>Medium</option>";
                    html+="<option value='3'>Heavy</option>";
                    html+="<option value='4'>Total Loss</option>";
                    html+="</select></div>";
                }
                else if(bcs[i]['contentDamage'] == 3){
                    html+="<option value='0'>None</option>";
                    html+="<option value='1'>Light</option>";
                    html+="<option value='2'>Medium</option>";
                    html+="<option value='3' selected>Heavy</option>";
                    html+="<option value='4'>Total Loss</option>";
                    html+="</select></div>";
                }
                else if(bcs[i]['contentDamage'] == 4){
                    html+="<option value='0'>None</option>";
                    html+="<option value='1'>Light</option>";
                    html+="<option value='2'>Medium</option>";
                    html+="<option value='3'>Heavy</option>";
                    html+="<option value='4' selected>Total Loss</option>";
                    html+="</select></div>";
                }


                html+="<div class='container-fluid'>";
                html+="<p style='float: left;'><b>Dwelling Damage:</b></p>" //<input style='float: right; text-align: right;' type=\"text\" name=\"dwellingDamage\" value=\"" + bcs[i]['dwellingDamage'] + "\"></div>";
                html+="<select  style='float: right; text-align: right;' class='form-control' name='dwellingDamage' id='policyHolderDropDown' >";

                if(bcs[i]['dwellingDamage'] == 0){
                    html+="<option value='0' selected>None</option>";
                    html+="<option value='1'>Light</option>";
                    html+="<option value='2'>Medium</option>";
                    html+="<option value='3'>Heavy</option>";
                    html+="<option value='4'>Total Loss</option>";
                    html+="</select></div>";
                }
                else if(bcs[i]['dwellingDamage'] == 1){
                    html+="<option value='0'>None</option>";
                    html+="<option value='1' selected>Light</option>";
                    html+="<option value='2'>Medium</option>";
                    html+="<option value='3'>Heavy</option>";
                    html+="<option value='4'>Total Loss</option>";
                    html+="</select></div>";
                }
                else if(bcs[i]['dwellingDamage'] == 2){
                    html+="<option value='0'>None</option>";
                    html+="<option value='1'>Light</option>";
                    html+="<option value='2' selected>Medium</option>";
                    html+="<option value='3'>Heavy</option>";
                    html+="<option value='4'>Total Loss</option>";
                    html+="</select></div>";
                }
                else if(bcs[i]['dwellingDamage'] == 3){
                    html+="<option value='0'>None</option>";
                    html+="<option value='1'>Light</option>";
                    html+="<option value='2'>Medium</option>";
                    html+="<option value='3' selected>Heavy</option>";
                    html+="<option value='4'>Total Loss</option>";
                    html+="</select></div>";
                }
                else if(bcs[i]['dwellingDamage'] == 4){
                    html+="<option value='0'>None</option>";
                    html+="<option value='1'>Light</option>";
                    html+="<option value='2'>Medium</option>";
                    html+="<option value='3'>Heavy</option>";
                    html+="<option value='4' selected>Total Loss</option>";
                    html+="</select></div>";
                }

                html+="<div class='container-fluid'>";
                html+="<p style='float: left;'><b>Flood Insurance:</b></p>" //<input id='policyHolderText' style='float: right; text-align: right;' type=\"text\" name=\"floodInsurance\" value=\"" + bcs[i]['floodInsurance'] + "\"></div>";
                html+="<select id='floodInsurance' style='float: right; text-align: right;' class='form-control' name='floodInsurance'>";

                if(bcs[i]['floodInsurance'] == 0){
                    html+="<option value='1'>Yes</option>";
                    html+="<option value='0' selected>No</option>";
                    html+="</select></div>";
                }
                else if(bcs[i]['floodInsurance'] == 1){
                    html+="<option value='1' selected>Yes</option>";
                    html+="<option value='0'>No</option>";
                    html+="</select></div>";
                }

                html += "<div class='container-fluid' id='floodInsurer'>";
                html += "<p style='float: left;'><b>Flood Insurer:</b></p> <input id='policyHolderText' style='float: right; text-align: right;' type=\"text\" name=\"floodInsurer\" value=\"" + bcs[i]['floodInsurer'] + "\"></div>";

                html+="<div class='container-fluid'>";
                html+="<p style='float: left;'><b>Claims Adjuster:</b></p> <input id='policyHolderText' style='float: right; text-align: right;' type=\"text\" name=\"username\" value=\"" + bcs[i]['U_USERNAME'] + "\"></div>";

                html+="<div class='container-fluid'>";
                html+="<p style='float: left;'><b>Status:</b></p>" //<input style='float: right; text-align: right;' type=\"text\" name=\"status\" value=\"" + bcs[i]['status'] + "\"></div>";
                html+="<select  style='float: right; text-align: right;' class='form-control' name='status' id='policyHolderDropDown' >";

                if(bcs[i]['status'] == 0){
                    html+="<option value='0' selected>New Claim</option>";
                    html+="<option value='1'>Assigned Claim</option>";
                    html+="<option value='2'>Closed Claim</option>";
                    html+="</select></div>";
                }
                else if(bcs[i]['status'] == 1){
                    html+="<option value='0'>New Claim</option>";
                    html+="<option value='1' selected>Assigned Claim</option>";
                    html+="<option value='2'>Closed Claim</option>";
                    html+="</select></div>";
                }
                else if(bcs[i]['status'] == 2){
                    html+="<option value='0'>New Claim</option>";
                    html+="<option value='1'>Assigned Claim</option>";
                    html+="<option value='2' selected>Closed Claim</option>";
                    html+="</select></div>";
                }

                html+="<div class='container-fluid'>";
                html+="<p style='float: left;'><b>Date:</b></p> <input id='policyHolderText' style='float: right; text-align: right;' type=\"date\" name=\"date\" value=\"" + bcs[i]['date'] + "\"></div>";

                html+="<input type=\"hidden\" name=\"claim\" value=\""+ bcs[i]['id'] + "\">";
                html+="<input type=\"hidden\" name=\"type\" value=\"business\">";
                html+="<input type=\"hidden\" name=\"d_id\" value=\""+ bcs[i]['D_ID'] + "\">";

                html+="<input type=\"Submit\" class='btn btn-primary' value=\"Save\"></p></form></div><br>";
            }

            $("#business").append(html+"</div></div>");
            $('#personal').hide();
            $('#business').show();
        }

        if (bcs.length == 0) {
            $('#business').hide();
        }
        if (pcs.length == 0){
            $('#personal').hide();
        }

        $('#PH_Modal').modal('show');
    });
}


/**
 * Calls polyPoints array and checks to see if if Policy Holders address is within the bounds of the Polygon
 * Once established that it is within the polygon it Stretches the bounds of each address
 * After all Address markers parsed Center of bounds is determined and A Marker Pin is placed
 * in the center of Policyholder Addresses
 *
 */
function center_policies() {

    centerMarker.setMap(null);
    for(var i = 0; i < propPoints.length; i++) {

        var Position = new google.maps.LatLng(propPoints[i]['lat'],propPoints[i]['lng']);
        var Polygon = new google.maps.Polygon({
            paths: polyPoints
        });
        if(google.maps.geometry.poly.containsLocation(Position, Polygon)) {
            if(propPoints[i]['lat'] > north){north = propPoints[i]['lat'];}
            if(propPoints[i]['lat'] < south){south = propPoints[i]['lat'];}
            if(propPoints[i]['lng'] > east){east = propPoints[i]['lng'];}
            if(propPoints[i]['lng'] < west){west = propPoints[i]['lng'];}
        }
    }

    var lat = (north + south)/2;
    var lng = (east + west)/2;

    centerMarker = new google.maps.Marker({
        position: {lat: lat, lng: lng},
        icon: "img/center1.png",
        size: new google.maps.Size(50, 50),
        origin: new google.maps.Point(-275, -280),
        //anchor: new google.maps.Point(-275, -275),
        map: map
    });

    centerMarker.setMap(map);

    for(var j = 0; j < polyPoints.length; j++) {
        ///console.log(polyPoints[j]['lat']);
        var latlng = new google.maps.LatLng(polyPoints[j]['lat'],polyPoints[j]['lng']);
        bound.extend(latlng);

    }

    map.fitBounds(bound);
}
