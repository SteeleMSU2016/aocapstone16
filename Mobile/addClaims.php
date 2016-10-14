<?php
/**
 * Created by PhpStorm.
 * User: cse498
 * Date: 3/2/16
 * Time: 3:58 PM
 *
 * Grabs the claims from the mobile application and adds them to the database
 */

require 'mobile.inc.php';
require 'mobile.localize.inc.php';

echo("Received");

if(isset($_POST['claims'])){
    $perClaims = new PersonalClaims($site);
    $busClaims = new BusinessClaims($site);
    $claims = json_decode($_POST['claims'], true);
    $personalClaims = $claims['personalClaims'];
    $businessClaims = $claims['businessClaims'];

    foreach($personalClaims as $pc){
        print_r($pc);
        $perClaims->updatePersonalClaims($pc);
    }

    foreach($businessClaims as $bc){
        print_r($bc);
        $busClaims->updateBusinessClaims($bc);
    }
}
