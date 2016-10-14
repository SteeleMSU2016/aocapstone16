<?php
/**
 * Created by PhpStorm.
 * User: cse498
 * Date: 2/17/16
 * Time: 8:33 PM
 */

require '../lib/site.inc.php';

$agencies= new Properties($site);
$agency = $agencies->getProperties();