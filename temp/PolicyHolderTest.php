<?php
/**
 * Created by PhpStorm.
 * User: cse498
 * Date: 2/17/16
 * Time: 7:56 PM
 */

require '../lib/site.inc.php';

$policyHolders = new PolicyHolders($site);
$policyHolder = $policyHolders->getPolicyHolders();