<?php
/**
 * Created by PhpStorm.
 * User: cse498
 * Date: 2/19/16
 * Time: 8:33 PM
 *
 * retrieves the information regarding the selected property on the policy page
 */

require '../lib/site.inc.php';
require '../lib/autoload.inc.php';
require '../lib/localize.inc.php';

if(isset($_GET['prop_id'])) {
    $prop_id = $_GET['prop_id'];
    $phs = new PolicyHolders($site);
    $ps = new Policies($site);
    $as = new Agencies($site);
    $props = new Properties($site);
    $busClaims = new BusinessClaims($site);
    $perClaims = new PersonalClaims($site);

    //get information
    $prop = $props->getProperty($prop_id);
    $policy = $ps->getPolicy($prop->getPID());
    $ph = $phs->getPolicyHolder($policy->getPHID());
    $agency = $as->getAgency($policy->getAID());
    //$pcs = $perClaims->getPersonalClaimsfromProperty($prop_id);
    //$bcs = $busClaims->getBusinessClaimsfromProperty($prop_id);
    $pcs = $perClaims->getPersonalClaimsfromPropertyAndDisaster($prop_id, $_SESSION['d_id']);
    $bcs = $busClaims->getBusinessClaimsfromPropertyAndDisaster($prop_id, $_SESSION['d_id']);

    //Serialize Personal Claims
    $per = "[";
    foreach ($pcs as $pc) {
        $per .= $pc->serialize();
        $per .= ",";
    }
    $per = rtrim($per, ",");
    $per .= "]";

    //Serialize Business Claims
    $bus = "";
    $bus = "[";
    foreach ($bcs as $bc) {
        $bus .= $bc->serialize();
        $bus .= ",";
    }
    $bus = rtrim($bus, ",");
    $bus .= "]";

    //create serialization
    $result = "";
    $result .= "{\"policyHolder\":";
    $result .= $ph->serialize();
    $result .= ", \"policy\":";
    $result .= $policy->serialize();
    $result .= ", \"property\":";
    $result .= $prop->serialize();
    $result .= ", \"agency\":";
    $result .= $agency->serialize();
    $result .= ", \"personalClaims\":";
    $result .= $per;
    $result .= ", \"businessClaims\":";
    $result .= $bus;
    $result .= "}";
    echo($result);
}