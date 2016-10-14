<?php
/**
 * Created by PhpStorm.
 * User: Nick
 * Date: 3/26/2016
 * Time: 2:59 AM
 *
 * updates claim based on the saved information from policy page
 */

$login = true;
require '../lib/site.inc.php';

if(isset($_POST['sorting'])){
    $_SESSION['sort'] = $_POST['sorting'];

}

if(isset($_POST['claim'])){
    if($_SESSION['user']->getSecurity() > 1 ||
        ($_SESSION['user']->getSecurity() == 1 && $_POST['U_USERNAME'] == $_SESSION['user']->getUsername()))
    {
        echo("PASSED SECURITY<br />");
        if($_POST['type'] == 'business'){
            $busClaims = new BusinessClaims($site);
            $row = array();
            $row['disaster'] = $_POST['d_id'];
            $row['contentDamage'] = $_POST['contentDamage'];
            $row['dwellingDamage'] = $_POST['dwellingDamage'];
            $row['floodInsurance'] = $_POST['floodInsurance'];
            if($row['floodInsurance'] == 1){
                $row['floodInsurer'] = $_POST['floodInsurer'];
            }
            else if ($row['floodInsurance'] == 0){
                $row['floodInsurer'] = '';
            }
            $row['username'] = $_POST['username'];
            $row['status'] = $_POST['status'];
            $row['date'] = $_POST['date'];
            //$row['notes'] = $_POST['notes'];
            $busClaims->updateBusinessClaim($_POST['claim'], $row);
        }
        if($_POST['type'] == 'personal'){
            $perClaims = new PersonalClaims($site);
            $row = array();
            $row['disaster'] = $_POST['d_id'];
            $row['contentDamage'] = $_POST['contentDamage'];
            $row['dwellingDamage'] = $_POST['dwellingDamage'];
            $row['otherDamage'] = $_POST['otherDamage'];
            $row['floodInsurance'] = $_POST['floodInsurance'];
            if($row['floodInsurance'] == 1){
                $row['floodInsurer'] = $_POST['floodInsurer'];
            }
            else if ($row['floodInsurance'] == 0){
                $row['floodInsurer'] = '';
            }
            $row['username'] = $_POST['username'];
            $row['status'] = $_POST['status'];
            $row['date'] = $_POST['date'];
            //$row['notes'] = $_POST['notes'];
            $perClaims->updatePersonalClaim($_POST['claim'], $row);
        }
    }
}

header("location: ../policy.php");