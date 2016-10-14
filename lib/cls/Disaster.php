<?php

/**
 * Created by PhpStorm.
 * User: cse498
 * Date: 2/12/16
 * Time: 2:38 AM
 */
class Disaster
{
    private $id;
    private $name;
    private $date;
    private $city;
    private $state;
    private $polygon;
    private $reason;
    private $createdBy;

    public function __construct($row) {
        $this->id = $row['id'];
        $this->name = $row['name'];
        $this->date = $row['date'];
        $this->city = $row['city'];
        $this->state = $row['state'];
        $this->polygon = $row['polygon'];
        $this->reason = $row['reason'];
        $this->createdBy = $row['createdBy'];
    }

    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function getDate()
    {
        return $this->date;
    }

    public function getReadableDate(){
        $orgDate = $this->date;
        $newDate = substr($orgDate, 5, 2). "/". substr($orgDate, 8,2) . "/" . substr($orgDate, 0, 4);
        return $newDate;
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
    public function getPolygon()
    {
        return $this->polygon;
    }

    public function getReason() {
        return $this->reason;
    }

    /**
     * @return mixed
     */
    public function getCreatedBy()
    {
        return $this->createdBy;
    }

    public function serialize() {
        $disaster = "{";
        $disaster.="\"id\":$this->id,";
        $disaster.="\"name\":\"$this->name\",";
        $disaster.="\"date\":\"$this->date\",";
        $disaster.="\"city\":\"$this->city\",";
        $disaster.="\"state\":\"$this->state\",";
        if($this->polygon === null) {
            $disaster.="\"polygon\":[],";
        }
        else{
            $disaster.="\"polygon\":$this->polygon,";
        }
        $disaster.="\"reason\":\"$this->reason\",";
        $disaster.="\"createdBy\":\"$this->createdBy\"";
        $disaster.="}";
        return $disaster;
    }

    public function __toString() {
        return $this->serialize();
    }
}