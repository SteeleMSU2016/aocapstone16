<?php
/**
 * Created by PhpStorm.
 * User: cse498
 * Date: 2/17/16
 * Time: 7:47 PM
 */

require '../lib/site.inc.php';

$agencies= new DisasterDatasets($site);
$agencies->getDisasterPolicyCombo();
echo("<br /><br />");
$agencies->getDisasterPolicies(1);