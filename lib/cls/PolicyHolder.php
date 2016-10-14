<?php

/**
 * Created by PhpStorm.
 * User: cse498
 * Date: 2/12/16
 * Time: 2:43 AM
 */
class PolicyHolder
{
    private $id;
    private $firstName;
    private $lastName;
    private $address;
    private $city;
    private $state;
    private $zipCode;
    private $primPhoneNumber;
    private $secPhoneNumber;

    /**
     * Constructor takes a row from the database
     * @param $row
     */
    public function __construct($row) {
        $this->id = $row['id'];
        $this->firstName = $row['firstName'];
        $this->lastName = $row['lastName'];
        $this->address = $row['address'];
        $this->city = $row['city'];
        $this->state = $row['state'];
        $this->zipCode = $row['zipCode'];
        $this->primPhoneNumber = $row['primPhoneNumber'];
        $this->secPhoneNumber = $row['secPhoneNumber'];
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @return mixed
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @return mixed
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @return mixed
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @return mixed
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @return mixed
     */
    public function getZipCode()
    {
        return $this->zipCode;
    }


    /**
     * @return mixed
     */
    public function getPrimPhoneNumber()
    {
        return $this->primPhoneNumber;
    }

    /**
     * @return mixed
     */
    public function getSecPhoneNumber()
    {
        return $this->secPhoneNumber;
    }

    /**
     * Created a JSON string of the object
     * @return string
     */
    public function serialize() {
        $policyHolder = "{";
        $policyHolder.="\"id\":$this->id,";
        $policyHolder.="\"firstName\":\"$this->firstName\",";
        $policyHolder.="\"lastName\":\"$this->lastName\",";
        $policyHolder.="\"address\":\"$this->address\",";
        $policyHolder.="\"city\":\"$this->city\",";
        $policyHolder.="\"state\":\"$this->state\",";
        $policyHolder.="\"zipCode\":\"$this->zipCode\",";
        $policyHolder.="\"primPhoneNumber\":\"$this->primPhoneNumber\",";
        $policyHolder.="\"secPhoneNumber\":\"$this->secPhoneNumber\"";
        $policyHolder.="}";
        return $policyHolder;
    }

    /**
     * allows the object to be turned into a string
     * @return string
     */
    public function __toString() {
        return $this->serialize();
    }
}