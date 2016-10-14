<?php
/**
 * Created by PhpStorm.
 * User: cse498
 * Date: 2/19/16
 * Time: 8:33 PM
 *
 * saves the disaster datasets and retrieves the property and claim status
 */

require '../lib/site.inc.php';
require '../lib/autoload.inc.php';
require '../lib/localize.inc.php';

function getPropStatus($prop, $site){
    $perClaims  =new PersonalClaims($site);
    $busClaims  =new BusinessClaims($site);
    $result = -1;
    $none = true;
    $closed = false;
    $inProgress = false;
    $new = false;

    //$perclms = $perClaims->getPersonalClaimsfromProperty($prop);
    //$busclms = $busClaims->getBusinessClaimsfromProperty($prop);
    $perclms = $perClaims->getPersonalClaimsfromPropertyAndDisaster($prop, $_SESSION['d_id']);
    $busclms = $busClaims->getBusinessClaimsfromPropertyAndDisaster($prop, $_SESSION['d_id']);
    foreach($perclms as $pc){
        $status = $pc->getStatus();
        if($status == 0){
            $new = true;
            $result = 0;
        }
        else if($status == 1 && !$new){
            $inProgress = true;
            $result = 1;
        }
        else if($status == 2 && !$new && !$inProgress){
            $closed = true;
            $result = 2;
        }
    }
    foreach($busclms as $bc){
        $status = $bc->getStatus();
        if($status == 0){
            $new = true;
            $result = 0;
        }
        else if($status == 1 && !$new){
            $inProgress = true;
            //$result = $bc;
            $result = 1;
        }
        else if($status == 2 && !$new && !$inProgress){
            $closed = true;
            $result = 2;
        }
    }
    /*if($result == -1){
        return $result;
    }
    else{
        return $result->getStatus();
    }*/
    return $result;

}

if(isset($_POST['update']) && isset($_POST['lat']) && isset($_POST['lng']) && isset($_POST['id'])){
    $properties = new Properties($site);
    $properties->updateLatLngFromId($_POST['id'], $_POST['lat'], $_POST['lng']);
    echo("Received");
    exit;
}

if(isset($_GET['disaster']) && $_GET['disaster'] == 'new') {
    $properties = new Properties($site);
    $propJSON = $properties->getProperties();
    echo("{\"properties\":");
    echo($propJSON);
    echo(",\"duck\": ");
    $duck=<<<DUCK
       ,~~.
      (  6 )-_,
 (\___ )=='-'
  \ .   ) )
   \ `-' /    BONUS DUCKS!
~'`~'`~'`~'`~
DUCK;
    echo(json_encode($duck));
    echo("}");
    exit;
}

else if(isset($_GET['disaster']) && $_GET['disaster'] == 'existing' && isset($_GET['d_id'])) {
    $properties = new Properties($site);

    $disasters = new Disasters($site);
    $disaster = $disasters->getDisasterFromId($_GET['d_id']);

    $per = "[";

    if(isset($_GET['personal'])){
        $per = "[";
        $dset = new DisasterDatasets($site);
        $props = $dset->getPropertyIdsFromDisaster($_GET['d_id']);
        foreach($props as $prop){
            $id = $prop['Prop_ID'];
            $status = getPropStatus($id, $site);
            $per.="{\"id\": $id, \"status\": $status},";
        }
        $per = rtrim($per, ",");
    }
    $per.="]";

    $result = "{";
    $result.="\"disaster\":";
    $result.=$disaster->serialize();
    $result.=",";
    $result.="\"properties\":";
    $result.=$properties->getProperties();
    //rtrim($result, "]");
    $result.=",";
    $result.="\"claims\": $per";
    $result.=",";
    $result.="\"duck\": ";
    $duck=<<<DUCK
       ,~~.
      (  6 )-_,
 (\___ )=='-'
  \ .   ) )
   \ `-' /    BONUS DUCKS!
~'`~'`~'`~'`~
DUCK;
    $result.=json_encode($duck);

    $result.="}";


    echo($result);
    exit;
}

else{
    exit;
}