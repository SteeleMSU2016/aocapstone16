<?php
/**
 * Created by PhpStorm.
 * User: cse498
 * Date: 2/10/16
 * Time: 2:09 PM
 *
 * removes the user from the session after logout
 */

$login = false;
require '../lib/site.inc.php';
unset($_SESSION['user']);
header("location: ../login.php");