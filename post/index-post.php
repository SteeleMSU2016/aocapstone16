<?php
/**
 * Created by PhpStorm.
 * User: cse498
 * Date: 2/20/16
 * Time: 3:44 PM
 *
 * sets the session disaster and type based on selected disaster on idex
 */

$login = true;
require '../lib/site.inc.php';

$_SESSION['sort'] = "A - Z";

if(isset($_GET['type']) && isset($_GET['d_id'])){
    $_SESSION['type'] = $_GET['type'];
    $_SESSION['d_id'] = $_GET['d_id'];
    header("location: ../map.php");
    exit;
}

else if(isset($_GET['type'])){
    $_SESSION['type'] = $_GET['type'];
    $_SESSION['d_id'] = -1;
    header("location: ../map.php");
    exit;
}

header("location: ../index.php");