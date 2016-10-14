/**
 * Created by cse498 on 2/21/16.
 */
function policy(geocoder, map){
    var type = document.getElementById('type').value;
    var d_id = document.getElementById('d_id').value;
    var new_url = "/ajax/mapAjax.php?disaster="+type;
    if(d_id != -1){
        new_url = new_url+"&d_id="+d_id;
    }
    else {
    }
    $.ajax({url: new_url, success: function(result){
        var new_array = [];
        var temp = JSON.parse(result);
        //alert(temp['properties']);
        for(var i = 0; i < temp['properties'].length; i++) {
            var new_string = "";
            new_string +=temp['properties'][i]['address'];
            new_string +=temp['properties'][i]['address'];
            new_string += ",";
            new_string +=temp['properties'][i]['city'];
            new_string += ",";
            new_string +=temp['properties'][i]['state'];
            new_string += " ";
            new_string +=temp['properties'][i]['zipCode'];
            new_array.push(new_string);

        }

        //DO LOGic here
    }});


}

function policyName(geocoder, map){
    var type = document.getElementById('type').value;
    var d_id = document.getElementById('d_id').value;
    var new_url = "/ajax/mapAjax.php?disaster="+type;
    if(d_id != -1){
        new_url = new_url+"&d_id="+d_id;
    }
    else {
    }
    $.ajax({url: new_url, success: function(result){
        var new_array = [];
        var temp = JSON.parse(result);
        //alert(temp['properties']);
        for(var i = 0; i < temp['properties'].length; i++) {
            var new_string = "";
            new_string +=temp['properties'][i]['address'];

        }

        //DO LOGic here
    }});


}
