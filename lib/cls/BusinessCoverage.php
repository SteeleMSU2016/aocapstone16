<?php

/**
 * Created by PhpStorm.
 * User: cse498
 * Date: 2/17/16
 * Time: 1:05 AM
 */
class BusinessCoverage
{
    private $id;
    private $name;
    private $Prop_ID;
    private $Blgd_ID;
    private $amount;
    private $deductAmount;
    private $percentColns;
    private $description;

    /**
     * BusinessCoverage constructor.
     * @param $row
     */
    public function __construct($row) {
        $this->id = $row['id'];
        $this->name = $row['name'];
        $this->Prop_ID = $row['Prop_ID'];
        $this->Blgd_ID = $row['Blgd_ID'];
        $this->amount = $row['amount'];
        $this->deductAmount = $row['deductAmount'];
        $this->percentColns = $row['percentCoIns'];
        $this->description = $row['description'];
    }

    /**
     * Getter to return Business Coverage Name
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Getter to return Business Coverage Bldg ID
     * @return mixed
     */
    public function getBlgdID()
    {
        return $this->Blgd_ID;
    }

    /**
     * Getter to return Business Coverage Prop ID
     * @return mixed
     */
    public function getPropID()
    {
        return $this->Prop_ID;
    }

    /**
     * Getter to return Business Coverage Amount
     * @return mixed
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Getter to return Business Coverage Deductable Amount
     * @return mixed
     */
    public function getDeductAmount()
    {
        return $this->deductAmount;
    }

    /**
     * Getter to return Business Coverage id
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Getter to return Business Coverage Description
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Getter to return Business Coverage Percent Colns
     * @return mixed
     */
    public function getPercentColns()
    {
        return $this->percentColns;
    }

    /**
     * Function to turn Business Coverage Object into a JSON Object
     * @return string
     */
    public function serialize() {
        $coverage = "{";
        $coverage.="\"id\":$this->id,";
        $coverage.="\"name\":\"$this->name\",";
        $coverage.="\"Prop_ID\":$this->Prop_ID,";
        $coverage.="\"Bldg_ID\":$this->Blgd_ID,";
        $coverage.="\"amount\":$this->amount,";
        $coverage.="\"deductAmount\":$this->deductAmount,";
        $coverage.="\"percentColns\":\"$this->percentColns\",";
        $coverage.="\"description\":\"$this->description\"";
        $coverage.="}";
        return $coverage;
    }

    /**
     * Function to return the serialization of Business Coverage
     * @return string
     */
    public function __toString() {
        return $this->serialize();
    }
}