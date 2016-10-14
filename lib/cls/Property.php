<?php

/**
 * Created by PhpStorm.
 * User: cse498
 * Date: 2/17/16
 * Time: 12:58 AM
 */
class Property
{

    private $id;
    private $P_ID;
    private $address;
    private $city;
    private $state;
    private $zipCode;
    private $propType; //0 = business, 1 = personal
    private $lat;
    private $lng;
    private $size;

    /**
     * Constructor
     * @param $row
     */
    public function __construct($row) {
        $this->id = $row['id'];
        $this->P_ID = $row['P_ID'];
        $this->address = $row['address'];
        $this->city = $row['city'];
        $this->state = $row['state'];
        $this->zipCode = $row['zipCode'];
        $this->propType = $row['propType'];
        $this->lat = $row['lat'];
        $this->lng = $row['lng'];
        $this->size = $row['size'];
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
    public function getPID()
    {
        return $this->P_ID;
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
    public function getPropType()
    {
        return $this->propType;
    }

    /**
     * @return mixed
     */
    public function getLat()
    {
        return $this->lat;
    }

    /**
     * @return mixed
     */
    public function getLng()
    {
        return $this->lng;
    }

    /**
     * @return mixed
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * Returns serialized JSON string of object
     * @return string
     */
    public function serialize() {
        $property = "{";
        $property.="\"id\":$this->id,";
        $property.="\"P_ID\":$this->P_ID,";
        $property.="\"address\":\"$this->address\",";
        $property.="\"city\":\"$this->city\",";
        $property.="\"state\":\"$this->state\",";
        $property.="\"zipCode\":\"$this->zipCode\",";
        $property.="\"propType\":$this->propType,";
        $property.="\"lat\":$this->lat,";
        $property.="\"lng\":$this->lng,";
        $property.="\"size\":$this->size";
        $property.="}";
        return $property;
    }

    /**
     * Function to return string version of class
     * @return string
     */
    public function __toString() {
        return $this->serialize();
    }


}