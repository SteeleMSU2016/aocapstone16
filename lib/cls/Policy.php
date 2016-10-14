<?php

/**
 * Created by PhpStorm.
 * User: cse498
 * Date: 2/9/16
 * Time: 3:03 PM
 */
class Policy
{
    private $id;
    private $PH_ID;
    private $A_ID;
    private $coverageStart;
    private $coverageStop;
    private $policyType; //0 = house, 1 = vehicle
    private $notes;

    /**
     * Takes a table row and creates a Policy object
     * @param $row
     */
    public function __construct($row) {
        $this->id = $row['id'];
        $this->PH_ID = $row['PH_ID'];
        $this->A_ID = $row['A_ID'];
        $this->coverageStart = $row['coverageStart'];
        $this->coverageStop = $row['coverageStop'];
        $this->policyType = $row['policyType'];
        $this->notes = $row['notes'];

    }

    /**
     * @return mixed
     */
    public function getId(){
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getPHID(){
        return $this->PH_ID;
    }

    public function getAID(){
        return $this->A_ID;
    }

    /**
     * @return mixed
     */
    public function getCoverageStart()
    {
        return $this->coverageStart;
    }

    /**
     * @return mixed
     */
    public function getCoverageStop()
    {
        return $this->coverageStop;
    }

    /**
     * @return mixed
     */
    public function getPolicyType()
    {
        return $this->policyType;
    }

    /**
     * Returns a JSON serialized string version of the class
     * @return string
     */
    public function serialize() {
        $policy = "{";
        $policy.="\"id\":$this->id,";
        $policy.="\"PH_ID\":$this->PH_ID,";
        $policy.="\"A_ID\":$this->A_ID,";
        $policy.="\"coverageStart\":\"$this->coverageStart\",";
        $policy.="\"coverageStop\":\"$this->coverageStop\",";
        $policy.="\"policyType\":\"$this->policyType\",";
        $policy.="\"notes\":\"$this->notes\"";
        $policy.="}";
        return $policy;
    }

    /**
     * Function to create a string representation of the objects
     * @return string
     */
    public function __toString() {
        return $this->serialize();
    }


}