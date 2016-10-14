<?php
/**
 * Created by PhpStorm.
 * User: cse498
 * Date: 2/17/16
 * Time: 8:16 PM
 */

require '../lib/site.inc.php';

$agencies= new PersonalClaims($site);
$agency = $agencies->getPersonalClaims();