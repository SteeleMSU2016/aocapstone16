<?php
/**
 * Function to set up the database connection for the mobile app
 * @return PDO
 */
function pdo_connect() {
    try {
        // Production server
        $dbhost="mysql:host=localhost;dbname=auto-owners;";
        $user = "root";
        $password = "AOcapstone16";
        return new PDO($dbhost, $user, $password);
    } catch(PDOException $e) {
        die( "Unable to select database");
    }
}