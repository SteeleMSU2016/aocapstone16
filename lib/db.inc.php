<?php
/**
 * Created by PhpStorm.
 * User: Nick
 * Date: 1/28/2016
 * Time: 6:07 PM
 */

function pdo_connect() {
    $USER = "root";
    $PASSWORD = "AOcapstone16";
    try {
        // Production server
        $dbhost="mysql:host=localhost;dbname=auto-owners";
        $user = $USER;
        $password = $PASSWORD;
        return new PDO($dbhost, $user, $password);
    } catch(PDOException $e) {
        die( "Unable to select database: $e");
    }
}
