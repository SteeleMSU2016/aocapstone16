<?php
/**
 * Check to log user into database
 */
require 'mobile.inc.php';
require 'mobile.localize.inc.php';

if(!isset($_GET['username'])) {
	echo("{\"status\" : \"no\"}");
	exit;
}

if(!isset($_GET['password'])) {
	echo("{\"status\" : \"no\"}");
	exit;
}

$username = $_GET['username'];
$password = $_GET['password'];
$users = new Users($site);
$success = $users->login($username, $password);
if($success !== null){
    echo("{\"status\" : \"yes\"}");
    exit;
}
else {
    echo("{\"status\" : \"no\"}");
    exit;
}