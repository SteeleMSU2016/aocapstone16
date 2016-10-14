<?php
/**
 * Created by PhpStorm.
 * User: cse498
 * Date: 2/17/16
 * Time: 8:16 PM
 */

require '../lib/site.inc.php';

$agencies= new Users($site);
$user = new User(array("username"=>"Nick","security"=>3));
$agency = $agencies->getUsers();
echo("<br /><br />");
echo($user->serialize());