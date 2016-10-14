<?php

/**
 * Created by PhpStorm.
 * User: cse498
 * Date: 2/12/16
 * Time: 2:18 AM
 */
class Agency
{
    private $id;
    private $name;
    private $address;
    private $city;
    private $state;
    private $zipCode;

    /**
     * Agency constructor.
     * @param $row
     */
    public function __construct($row) {
        $this->id = $row['id'];
        $this->name = $row['name'];
        $this->address = $row['address'];
        $this->city = $row['city'];
        $this->state = $row['state'];
        $this->zipCode = $row['zipCode'];
    }

    /**
     * Getter to return Agency ID
     * @return mixed
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Getter to return Agency Name
     * @return mixed
     */
    public function getName() {
        return $this->name;
    }

    /**
     * Getter to return Agency Address
     * @return mixed
     */
    public function getAddress() {
        return $this->address;
    }

    /**
     * Getter to return Agency City
     * @return mixed
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Getter to return Agency State
     * @return mixed
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * Getter to return Agency ZipCode
     * @return mixed
     */
    public function getZipCode()
    {
        return $this->zipCode;
    }

    /**
     * Function to turn Agency Object into a JSON Object
     * @return string
     */
    public function serialize() {
        $agency = "{";
        $agency.="\"id\":$this->id,";
        $agency.="\"name\":\"$this->name\",";
        $agency.="\"address\":\"$this->address\",";
        $agency.="\"city\":\"$this->city\",";
        $agency.="\"state\":\"$this->state\",";
        $agency.="\"zipCode\":\"$this->zipCode\"";
        $agency.="}";
        return $agency;
    }

    /**
     * Function to return the serialization of Agency
     * @return string
     */
    public function __toString() {
        return $this->serialize();
    }
}