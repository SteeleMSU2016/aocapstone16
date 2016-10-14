<?php

/**
 * Created by PhpStorm.
 * User: cse498
 * Date: 2/18/16
 * Time: 1:59 PM
 */
class Vehicle
{

    private $id;
    private $P_ID;
    private $make;
    private $model;
    private $year;
    private $vinNumber;

    public function __construct($row) {
        $this->id = $row['id'];
        $this->P_ID = $row['P_ID'];
        $this->make = $row['make'];
        $this->model = $row['model'];
        $this->year = $row['year'];
        $this->vinNumber = $row['vinNumber'];
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
    public function getMake()
    {
        return $this->make;
    }

    /**
     * @return mixed
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * @return mixed
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * @return mixed
     */
    public function getVinNumber()
    {
        return $this->vinNumber;
    }

    public function serialize() {
        $vehicle = "{";
        $vehicle.="\"id\":$this->id,";
        $vehicle.="\"P_ID\":\"$this->P_ID\",";
        $vehicle.="\"make\":\"$this->make\",";
        $vehicle.="\"model\":\"$this->model\",";
        $vehicle.="\"year\":\"$this->year\",";
        $vehicle.="\"vinNumber\":\"$this->vinNumber\"";
        $vehicle.="}";
        return $vehicle;
    }

    public function __toString() {
        return $this->serialize();
    }
}