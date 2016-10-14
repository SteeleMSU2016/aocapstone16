<?php
/**
 * Created by PhpStorm.
 * User: cse498
 * Date: 3/30/16
 * Time: 2:01 PM
 *
 * returns all users from the Database
 */

require 'mobile.inc.php';

$users= new Users($site);
$query = $users->getAllUsers();

echo($query);