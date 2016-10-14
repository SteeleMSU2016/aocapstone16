<?php

/**
 * Created by PhpStorm.
 * User: cse498
 * Date: 2/9/16
 * Time: 3:03 PM
 */
class PolicyView
{
    private $site;
    private $firstTime = true;
    private $currentSort = "";

    /**
     * Constructor
     * @param Site $site
     */
    public function __construct(Site $site){
        $this->site = $site;
    }

    /**
     * returns the HTML string for the policy view
     * @return string
     */
    public function policyDisplay()
    {
        $this->firstTime = true;
        $result = "";
        $result.= '<div class="container-fluid" ><ul class="list-group">';
        $result_array = $this->getPropertyList();
        foreach($result_array as $item){
            $result.=$item;
        }
        $result.='</ul></div>';
        return $result;
    }

    /**
     * returns an array of html strings for each property
     * @return array
     */
    private function getPropertyList(){
        $all = $this->createPropertyObjectList();
        //Do sorting here
        $sort = "";
        if($_SESSION['sort'] == "A - Z"){
            usort($all, array('PolicyView','cmpAlpha'));
            $sort = "az";
        }
        else if($_SESSION['sort'] == "City"){
            usort($all, array('PolicyView','cmpCity'));
            $sort = "city";
        }
        else if($_SESSION['sort'] == "Zip Code"){
            usort($all, array('PolicyView','cmpZipCode'));
            $sort = "zipcode";
        }
        else if($_SESSION['sort'] == "State"){
            usort($all, array('PolicyView','cmpState'));
            $sort = "state";
        }
        else if($_SESSION['sort'] == "Claim Status"){
            usort($all, array('PolicyView','cmpClaimStatus'));
            $sort = "status";
        }
        else if($_SESSION['sort'] == "Agency"){
            usort($all, array('PolicyView','cmpAgency'));
            $sort = "agency";
        }

        $result_array = array();
        foreach($all as $row){
            $result = "";
            $id = $row['id'];
            $address = $row['address'];
            $state = $row['state'];
            $city = $row['city'];
            $zip = $row['zipcode'];
            $agency = $row['agency'];
            $firstname = $row['firstname'];
            $lastname = $row['lastname'];
            $status = $row['status'];

            switch ($row['status']) {
                case -1:
                    $status = "No Claim";
                    break;
                case 0:
                    $status = "New";
                    break;
                case 1:
                    $status = "Assigned";
                    break;
                case 2:
                    $status = "Closed";
                    break;
            }

            if($sort == "az"){
                if($row["lastname"][0] != $this->currentSort){
                    $rowSort = $row["lastname"][0];
                    $this->currentSort = $rowSort;
                    if ($this->firstTime == true){
                        $result.="<ul class=\"list-group\"><h3>$rowSort</h3><hr>";
                        $this->firstTime = false;
                    }
                    else{
                        $result.="</ul></div><div class=\"container-fluid\"><ul class=\"list-group\"><h3>$rowSort</h3><hr>";
                    }
                }
            }
            else if($sort == "status"){
                if($status != $this->currentSort){
                    $this->currentSort = $status;
                    if ($this->firstTime == true){
                        $result.="<ul class=\"list-group\"><h3>$status</h3><hr>";
                        $this->firstTime = false;
                    }
                    else {
                        $result .= "</ul></div><div class=\"container-fluid\"><ul class=\"list-group\"><h3>$status</h3><hr>";
                    }
                }
            }
            else{
                if($row[$sort] != $this->currentSort){
                    $this->currentSort = $row[$sort];
                    $rowSort = $row[$sort];
                    if ($this->firstTime == true){
                        $result.="<ul class=\"list-group\"><h3>$rowSort</h3><hr>";
                        $this->firstTime = false;
                    }
                    else{
                        $result.="</ul></div><div class=\"container-fluid\"><ul class=\"list-group\"><h3>$rowSort</h3><hr>";
                    }
                }
            }
            $result .= <<<RESULT
<li class="list-group-item col-xs-6">
    <div onclick="displayPolicyModal($id)">
        <p id="name"><b>$lastname, $firstname</b></p><hr id="nameHR">
        <p>
            <b><small>Address:</small></b> <br>
            <small>&nbsp;&nbsp;&nbsp;&nbsp;$address</small><br>
            <small>&nbsp;&nbsp;&nbsp;&nbsp;$city, $state $zip</small><br><br>
            <small><b>Agency:</b> &nbsp;&nbsp;$agency</small><br>
            <small><b>Claim:</b> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$status</small>
        </p>
    </div>
</li>
RESULT;
            array_push($result_array, $result);
        }

        return $result_array;
    }

    /**
     * creates an array of indexed arrays for each property and the information needed
     * @return array
     */
    private function createPropertyObjectList(){
        $result = array();
        $disasters = new DisasterDatasets($this->site);
        $policies = new Policies($this->site);
        $policyHolders = new PolicyHolders($this->site);
        $properties = new Properties($this->site);
        $agencies = new Agencies($this->site);
        $props = $disasters->getPropertyIdsFromDisaster($_SESSION['d_id']);
        foreach($props as $prop){
            $new_prop = array();
            $prop = $properties->getProperty($prop['Prop_ID']);
            $new_prop['id'] = $prop->getId();
            $new_prop['address'] = $prop->getAddress();
            $new_prop['state'] = $prop->getState();
            $new_prop['city'] = $prop->getCity();
            $new_prop['zipcode'] = $prop->getZipCode();
            $policy = $policies->getPolicy($prop->getPID());
            $new_prop['agency'] = $agencies->getAgency($policy->getAID())->getName();
            $ph = $policyHolders->getPolicyHolder($policy->getPHID());
            $new_prop['firstname'] = $ph->getFirstName();
            $new_prop['lastname'] = $ph->getLastName();
            $new_prop['status'] = $this->getPropStatus($prop->getId());

            array_push($result, $new_prop);
        }
        return $result;
    }

    /**
     * takes a property ID and then finds its overall claim status
     * @param $prop
     * @return int
     */
    private function getPropStatus($prop){
        $perClaims  =new PersonalClaims($this->site);
        $busClaims  =new BusinessClaims($this->site);
        $result = -1;
        $none = true;
        $closed = false;
        $inProgress = false;
        $new = false;

        $perclms = $perClaims->getPersonalClaimsfromPropertyAndDisaster($prop, $_SESSION['d_id']);
        $busclms = $busClaims->getBusinessClaimsfromPropertyAndDisaster($prop, $_SESSION['d_id']);
        foreach($perclms as $pc){
            $status = $pc->getStatus();
            if($status == 0){
                $new = true;
                $result = 0;
            }
            else if($status == 1 && !$new){
                $inProgress = true;
                $result = 1;
            }
            else if($status == 2 && !$new && !$inProgress){
                $closed = true;
                $result = 2;
            }
        }
        foreach($busclms as $bc){
            $status = $bc->getStatus();
            if($status == 0){
                $new = true;
                $result = 0;
            }
            else if($status == 1 && !$new){
                $inProgress = true;
                //$result = $bc;
                $result = 1;
            }
            else if($status == 2 && !$new && !$inProgress){
                $closed = true;
                $result = 2;
            }
        }

        return $result;

    }

    public function sortingBar(){
        $zip = "";
        $az = "";
        $city = "";
        $state = "";
        $agency = "";
        $status = "";

        if($_SESSION['sort'] == "A - Z"){
            $az = "checked";
        }
        else if($_SESSION['sort'] == "Zip Code"){
            $zip = "checked";
        }
        else if($_SESSION['sort'] == "City"){
            $city = "checked";
        }
        else if($_SESSION['sort'] == "State"){
            $state = "checked";
        }
        else if($_SESSION['sort'] == "Agency"){
            $agency = "checked";
        }
        else if($_SESSION['sort'] == "Claim Status"){
            $status = "checked";
        }

        $html =<<<HTML
        <div class="panel panel-default" id="policyStoring">
            <div class="panel-body" id="policyStoringBody">
                <h4>Policy Sorting</h4>
                <div class="container-fluid">
                <form method="POST" action="/post/policy-post.php">
                    <div class="radio">
                        <label><input type="radio" name="sorting" $az value="A - Z">A - Z</label>
                    </div>
                    <div class="radio">
                        <label><input type="radio" name="sorting" $zip value="Zip Code">Zip Code</label>
                    </div>
                    <div class="radio">
                        <label><input type="radio" name="sorting" $city value="City">City</label>
                    </div>
                    <div class="radio">
                        <label><input type="radio" name="sorting" $state value="State">State</label>
                    </div>
                    <div class="radio">
                        <label><input type="radio" name="sorting" $agency value="Agency">Agency</label>
                    </div>
                    <div class="radio">
                        <label><input type="radio" name="sorting" $status value="Claim Status">Claim Status</label>
                    </div>
                    <input type="submit" class="btn btn-primary" value="Sort">
                </form>
                </div>
            </div>
        </div>
HTML;

        return $html;
    }

    private function cmpAlpha($a, $b){
        return strcmp($a['lastname']." ".$a['firstname'], $b['lastname']." ".$b['firstname']);
        /*$a = $a['lastname'].", ".$a['firstname'];
        $b = $b['lastname'].", ".$b['firstname'];
        if ($a == $b){
            return 0;
        }
        return ($a < $b) ? -1 : 1;*/
    }

    private function cmpZipCode($a, $b){
        if ($a['zipcode'] == $b['zipcode']){
            return $this->cmpAlpha($a,$b);
        }
        return strcmp($a['zipcode'], $b['zipcode']);
    }

    private function cmpCity($a, $b){
        if($a['city'] == $b['city']){
            return $this->cmpAlpha($a,$b);
        }
        return strcmp($a['city'], $b['city']);
    }

    private function cmpState($a, $b){
        if($a['state'] == $b['state']){
            return $this->cmpAlpha($a,$b);
        }
        return strcmp($a['state'], $b['state']);
    }

    private function cmpClaimStatus($a, $b){
        if($a['status'] == $b['status']){
            return $this->cmpAlpha($a,$b);
        }
        return ($a['status'] > $b['status']) ? -1 : 1;
    }

    private function cmpAgency($a, $b){
        if($a['agency'] == $b['agency']){
            return $this->cmpAlpha($a,$b);
        }
        return strcmp($a['agency'], $b['agency']);
    }

    public function DisplayModal(){
        $modal = <<<MODAL
    <div class="modal fade" id="PH_Modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h2 class="modal-title" id="phName">Policy Holder Name</h2>
                </div>
                <div class="modal-body">
                    <!--<div class="form-group dis_save">-->
                        <div class="panel panel-default">
                            <div class="panel-heading" id="policyHolderHeading">
                                <big><b>Policyholder Information</b></big>
                            </div>
                            <div class="panel-body">
                                <div class="container-fluid">
                                    <p style="float: left;"><b>Name:</b></p><span id="ph_name" style="float: right;">Name</span>
                                </div>
                                <div class="container-fluid">
                                    <p style="float: left;"><b>Contact Address:</b></p><span id="ph_address" style="float: right;">Address</span>
                                    <!--<span id="ph_address2" style="float: right;">City, State zip</span>-->
                                </div>
                                <div class="container-fluid">
                                    <p style="float: left;"><b>Primary Phone:</b></p> <span id="ph_prim_phone" style="float: right;">Phone</span>
                                </div>
                                <div class="container-fluid">
                                    <p style="float: left;"><b>Secondary Phone:</b></p> <span id="ph_sec_phone" style="float: right;">Phone</span>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading" id="policyHolderHeading">
                                <big><b>Policy Information</b></big>
                            </div>
                            <div class="panel-body">
                                <div class="container-fluid">
                                    <p style="float: left;"><b>Coverage:</b></p><p style="float: right;"><span id="policy_start">Start</span> until <span id="policy_end">Stop</span></p>
                                </div>
                                <div class="container-fluid">
                                    <p style="float: left;"><b>Type:</b></p> <span id="policy_type" style="float: right;">Business/Personal</span>
                                </div>
                                <br>
                                <div class="panel panel-default">
                                    <div class="panel-heading" id="policyHolderHeading">
                                        <b>Agency</b>
                                    </div>
                                    <div class="panel-body">
                                        <div class="container-fluid">
                                            <p style="float: left;"><b>Agency Name:</b></p><span id="agency_name" style="float: right;">Name</span>
                                        </div>
                                        <div class="container-fluid">
                                            <p style="float: left;"><b>Agency Address:</b></p><span id="agency_address" style="float: right;">Address</span>
                                            <!--<span id="ph_address2" style="float: right;">City, State zip</span>-->
                                        </div>
                                        <!--<p>
                                            Agency name: <span id="agency_name">Name</span><br />
                                            Agency Address: <br/>
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            <span id="agency_address">Address</span><br />
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            <span id="agency_address2">City, State zip</span><br />
                                        </p>-->
                                    </div>
                                </div>
                                <div class="panel panel-default">
                                    <div class="panel-heading" id="policyHolderHeading">
                                        <b>Property</b>
                                    </div>
                                    <div class="panel-body">
                                        <div class="container-fluid">
                                            <p style="float: left;"><b>Property Address:</b></p><span id="prop_address" style="float: right;">Address</span>
                                        </div>
                                        <div class="container-fluid">
                                            <p style="float: left;"><b>Type:</b></p><span id="prop_type" style="float: right;">Business/Personal</span>
                                        </div>
                                        <div class="container-fluid">
                                            <p style="float: left;"><b>Size:</b></p><span id="prop_size" style="float: right;">Dollar Amount</span>
                                        </div>
                                        <!--<p>
                                            Property Address: <br/>
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            <span id="prop_address">Address</span><br />
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            <span id="prop_address2">City, State zip</span><br />
                                            Type: <span id="prop_type">Business/Personal</span><br />
                                            Size: <span id="prop_size">Dollar Amount</span>
                                        </p>-->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default" id="personal">

                        </div>
                        <div class="panel panel-default" id="business">

                        </div>
                    <!--</div>-->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
MODAL;
        return $modal;
    }
}

