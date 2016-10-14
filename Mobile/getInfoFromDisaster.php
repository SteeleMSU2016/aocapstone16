<?php
/**
 * Created by PhpStorm.
 * User: Nick
 * Date: 2/18/2016
 * Time: 8:18 PM
 *
 * returns information from the entire database based a disaster ID
 */

require 'mobile.inc.php';
require 'mobile.localize.inc.php';

function serializeArray($input, $key){
    $result = "";
    $result.="\"$key\":[";
    $end = count($input) - 1;
    $i = 0;
    foreach($input as $row) {
        $result.=$row->serialize();
        if ($i != $end) {
            $result .= ",";
        }
        $i+=1;
    }
    $result.="]";
    return $result;
}

if(!isset($_GET['d_id'])) {
    echo("{}");
    exit;
}

else {
    /*
     * INITIAL GRAB OF POLICIES AND DISASTER SET
     * dataset = select all from disasterdataset where d_id = $_GET['d_id']
     * policies = get all policies from DisasterSet where d_id = $_GET['d_id']
     *
     * GENERATES ARRAYS BASED ON POLICIES
     * policyHolders = for each policy select distinct from policyholder where PH_ID = policyHolder.id
     * properties = for each policy get all properties where P_ID = policy.id
     * agencies = for each policy select distinct from agency where A_ID = agency.id
     *
     * GENERATES ARRAYS BASED ON PROPERTIES
     * personalCoverages = for each property select from personalCoverage where Prop_ID = property.id
     * propForm = for each property select from propForm where Prop_ID = property.id
     * busCoverages = for each property select from busCoverage where Prop_ID = property.id
     * busPropBlgd = for each property select from BusPropBlgd where Prop_ID = property.id
     */

    $agencies = new Agencies($site);
    $busClaims = new BusinessClaims($site);
    $busCoverages = new BusinessCoverages($site);
    $busPropBlgd = new BusPropBlgds($site);
    $disasters = new Disasters($site);
    $dataset = new DisasterDatasets($site);
    $personalClaims = new PersonalClaims($site);
    $personalCoverages = new PersonalCoverages($site);
    $policies = new Policies($site);
    $policyForms = new PolicyForms($site);
    $policyHolders = new PolicyHolders($site);
    $properties = new Properties($site);
    $propForms = new PropForms($site);
    $users = new Users($site);

    //Get DisasterDataset
    $dset = $dataset->getDatasetFromDisaster($_GET['d_id']);

    //Get Policies
    $policy = array();
    foreach($dset as $row){
        array_push($policy, $policies->getPolicy($row->getPID()));
    }

    $policy = array_unique($policy);

    $ph = array();
    $prop = array();
    $agent = array();
    $policyForm = array();

    foreach($policy as $row){
        array_push($ph, $policyHolders->getPolicyHolder($row->getPHID()));
        $prop = array_merge($prop, $properties->getPropertiesFromPolicy($row->getId()));
        array_push($agent, $agencies->getAgency($row->getAID()));
        $policyForm = array_merge($policyForm, $policyForms->getFormsFromPolicy($row->getId()));
    }
    //make sure values are unique
    $ph = array_unique($ph);
    $prop = array_unique($prop);
    $agent = array_unique($agent);
    $policyForm = array_unique($policyForm);

    $perCov = array();
    $pForm = array();
    $busCov = array();
    $busBlgd = array();

    foreach($prop as $row) {
        $perCov = array_merge($perCov, $personalCoverages->getCoveragesFromProperty($row->getId()));
        $pForm = array_merge($pForm, $propForms->getPropFormsFromProperty($row->getId()));
        $busCov = array_merge($busCov, $busCoverages->getBusCoveragesFromProperty($row->getId()));
        $busBlgd = array_merge($busBlgd, $busPropBlgd->getBlgdFromProperty($row->getId()));
    }

    //make sure values are unique
    $perCov = array_unique($perCov);
    $pForm = array_unique($pForm);
    $busCov = array_unique($busCov);
    $busBlgd = array_unique($busBlgd);

    $result = "{";
    $result.= serializeArray($agent, 'agencies').",";
    $result.= serializeArray($busCov, 'busCoverages').",";
    $result.= serializeArray($busBlgd, 'busPropBlgd').",";
    $result.= serializeArray($dset, 'disasterDataset').",";
    $result.= serializeArray($perCov, 'personalCoverages').",";
    $result.= serializeArray($policy, 'policies').",";
    $result.= serializeArray($policyForm, 'policyForms').",";
    $result.= serializeArray($ph, 'policyHolders').",";
    $result.= serializeArray($prop, 'properties').",";
    $result.= serializeArray($pForm, 'propForms')."";
    $result.="}";

    echo $result;
}