<?php
/**
 * Created by PhpStorm.
 * User: cse498
 * Date: 3/2/16
 * Time: 1:03 PM
 *
 * saves the disaster dataset and the disaster from the mpa page
 */

require '../lib/site.inc.php';
require '../lib/autoload.inc.php';
require '../lib/localize.inc.php';

//echo("Received");

$d_id = -1;
$disasters = new Disasters($site);
$authed = false;

if($_SESSION['type'] == 'new'){
    if(isset($_POST['name']) && isset($_POST['date']) && isset($_POST['city'])
    && isset($_POST['state']) && isset($_POST['polygon']) && $_SESSION['user']->getSecurity() >= 1){
        $authed = true;
        $disasters = new Disasters($site);
        $d_id = $disasters->AddDisaster($_POST['name'], $_POST['date'], $_POST['city'], $_POST['state'], $_POST['polygon'], $_POST['reason'], $_SESSION['user']->getUsername());
        $_SESSION['type'] = 'existing';
        $_SESSION['d_id'] = $d_id;
    }
}

else if($_SESSION['type'] == 'existing'){
    if($_SESSION['user']->getSecurity() > 1 ||
        ($_SESSION['user']->getSecurity() == 1 && $disasters->getDisasterFromId($_SESSION['d_id'])->getCreatedBy() == $_SESSION['user']->getUsername())) {
        $authed = true;
        $d_id = $_SESSION['d_id'];
        if (isset($_POST['polygon'])) {
            $disasters = new Disasters($site);
            $disasters->updatePolygonFromId($d_id, $_POST['polygon']);
        }
    }
}

/*
 ************************************
 ************************************
 ** BEWARE!!!! VERY DANGEROUS!!!!! **
 ************************************
 ************************************
 */
/*
 * Ye be warned
 */
if($d_id != -1 && isset($_POST['properties']) && $authed){
    $set = new DisasterDatasets($site);
    $set->DeleteDisasterFromDataset($d_id);
    $properties = json_decode($_POST['properties'], true);
    $new_prop = array();
    $set->AddToDataset($d_id, $properties);
    foreach($properties as $prop){
        array_push($new_prop, new Property($prop));
    }
    $_SESSION['properties'] = $new_prop;
}