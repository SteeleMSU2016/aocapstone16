<?php

/**
 * Created by PhpStorm.
 * User: cse498
 * Date: 2/17/16
 * Time: 1:02 AM
 */
class PersonalCoverage
{

    private $name;
    private $Prop_ID;
    private $amount;
    private $deductAmount;
    private $description;

    public function __construct($row) {
        $this->name = $row['name'];
        $this->Prop_ID = $row['Prop_ID'];
        $this->amount = $row['amount'];
        $this->deductAmount = $row['deductAmount'];
        $this->description = $row['description'];
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getPropID()
    {
        return $this->Prop_ID;
    }

    /**
     * @return mixed
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @return mixed
     */
    public function getDeductAmount()
    {
        return $this->deductAmount;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    public function serialize() {
        $coverage = "{";
        $coverage.="\"name\":\"$this->name\",";
        $coverage.="\"Prop_ID\":$this->Prop_ID,";
        $coverage.="\"amount\":$this->amount,";
        $coverage.="\"deductAmount\":$this->deductAmount,";
        $coverage.="\"description\":\"$this->description\"";
        $coverage.="}";
        return $coverage;
    }

    public function __toString() {
        return $this->serialize();
    }


}