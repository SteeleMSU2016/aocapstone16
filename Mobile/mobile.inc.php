<?php
/**
 * Created by PhpStorm.
 * User: cse498
 * Date: 1/30/16
 * Time: 10:08 AM
 *
 * Site setup for mobile system
 */

require "../lib/autoload.inc.php";

$site = new Site();
$localize = require 'mobile.localize.inc.php';
if(is_callable($localize)) {
    $localize($site);
}
?>