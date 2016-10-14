<?php
/**
 * Created by PhpStorm.
 * User: cse498
 * Date: 2/17/16
 * Time: 1:34 PM
 */

require '../lib/site.inc.php';

$policies = new Policies($site);
$policies = $policies->getPolicies();
