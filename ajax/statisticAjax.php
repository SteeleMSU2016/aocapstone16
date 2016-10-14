<?php
/**
 * Created by PhpStorm.
 * User: cse498
 * Date: 2/19/16
 * Time: 8:33 PM
 */

require '../lib/site.inc.php';
require '../lib/autoload.inc.php';
require '../lib/localize.inc.php';

//Reference to the business and personal claims
$busClaims = new BusinessClaims($site);
$personalClaims = new PersonalClaims($site);

/**
 * This file recieves the type of statistical information that
 * the statistics page needs and sends back an array of that information
 * */
if(isset($_GET['action'])){

    $d_id = -1;
    $label = array("", "Count");
    $busCount; $personalCount;
    $claimCounts = array();
    $exists = false;


    if(isset($_GET['d_id'])){
        $d_id = strip_tags($_GET['d_id']);
    }

    /**
     * If the information needed is from the piechart
     */
    if($_GET['action'] == 'pieCategory'){

        /**
         * If the piechart category is Agency
         */
        if($_GET['pieCategory'] == 'Agency'){

            $busCount = $busClaims->countBusClaimsAgency($d_id);
            $personalCount = $personalClaims->countPersonalClaimsAgency($d_id);
            $label[0] = "Agency";

        }

        /**
         * If the piechart category is Branch
         */
        else if($_GET['pieCategory'] == 'Branch'){

            $busCount = $busClaims->countBranch($d_id);
            $personalCount = $personalClaims->countBranch($d_id);
            $label[0] = "Assigned Branch Territory";
        }

        /**
         * If the piechart category is Status
         */
        else if($_GET['pieCategory'] == 'Status'){

            $busCount = $busClaims->countStatus($d_id);
            $personalCount = $personalClaims->countStatus($d_id);
            $label[0] = "Status";
        }

        /**
         * If the piechart category is Adjuster
         */
        else if($_GET['pieCategory'] == 'Adjuster'){

            $busCount = $busClaims->countAdjuster($d_id);
            $personalCount = $personalClaims->countAdjuster($d_id);
            $label[0] = "Independ Adjuster";
        }

        /**
         * If the piechart category is PropType
         */
        else if($_GET['pieCategory'] == 'PropType'){

            $label = array('Property Type', 'Count');

            $personalCount = $personalClaims->countPropType($d_id);
            $busCount = $busClaims->countPropType($d_id);

            $personalArray = array('Personal', (int)$personalCount['COUNT(*)']);
            $busArray = array('Business', (int)$busCount['COUNT(*)']);


            if($busCount == null && $personalCount == null){
                echo json_encode($claimCounts);
                exit;
            }

            array_push($claimCounts, $label);

            if($busCount != null && $personalCount == null){
                array_push($claimCounts, $busArray);
            }
            else if ($personalCount != null && $busCount == null){
                array_push($claimCounts, $personalArray);
            }
            else if ($busCount != null && $personalCount != null){
                array_push($claimCounts, $personalArray);
                array_push($claimCounts, $busArray);
            }

            echo json_encode($claimCounts);
            exit;
        }

        /**
         * If the piechart category is City
         */
        else if($_GET['pieCategory'] == 'City'){

            $busCount = $busClaims->countCity($d_id);
            $personalCount = $personalClaims->countCity($d_id);
            $label[0] = "City";
        }

        /**
         * If the piechart category is State
         */
        else if($_GET['pieCategory'] == 'State'){

            $busCount = $busClaims->countState($d_id);
            $personalCount = $personalClaims->countState($d_id);
            $label[0] = "State";
        }
    }

    /**
     * If the information needed is
     * the Claim Count for the Last 10 Days
     */
    else if ($_GET['action'] == 'CountDays'){

        $busCount = $busClaims->countBusClaimsDay($d_id);
        $personalCount = $personalClaims->countPersonalClaimsDay($d_id);
        $label[0] = "Date";
    }

    /**
     * If the information needed is
     * the Claim Count by Agency
     */
    else if ($_GET['action'] == 'CountAgency'){

        $busCount = $busClaims->countBusClaimsAgency($d_id);
        $personalCount = $personalClaims->countPersonalClaimsAgency($d_id);
        $label[0] = "Agency";
    }

    /**
     * Now to go through the data
     **/

    /**
     * If there are only businessClaims
     */
    if($busCount != null && $personalCount == null ){

        array_push($claimCounts, $label);

        foreach ($busCount as $busRow){
            array_push($claimCounts, $busRow);
        }

        echo json_encode($claimCounts);
        exit;
    }

    /**
     * If there are only personal claims
     */
    else if ($personalCount != null && $busCount == null){

        array_push($claimCounts, $label);

        foreach ($personalCount as $personalRow){
            array_push($claimCounts, $personalRow);
        }

        echo json_encode($claimCounts);
        exit;
    }

    /**
     * If there are personal and business claims
     */
    else if ($busCount != null && $personalCount != null) {

        array_push($claimCounts, $label);

        foreach ($busCount as $busRow) {

            foreach ($personalCount as $personalRow) {

                if ($busRow[0] == $personalRow[0]) {
                    $total = $busRow[1] + $personalRow[1];
                    $claimCount = array($busRow[0], (int)$total);
                    array_push($claimCounts, $claimCount);
                    $exists = true;
                    break;
                }
            }

            if ($exists == false) {
                $claimCount = array($busRow[0], (int)$busRow[1]);
                array_push($claimCounts, $claimCount);
            }
            else
                $exists = false;
        }

        foreach ($personalCount as $personalRow) {

            foreach ($busCount as $busRow) {

                if ($personalRow[0] == $busRow[0]) {
                    $exists = true;
                    break;
                }
            }

            if ($exists == false) {
                $claimCount = array($personalRow[0], (int)$personalRow[1]);
                array_push($claimCounts, $claimCount);
            }
            else
                $exists = false;
        }

        echo json_encode($claimCounts);
        exit;
    }
}