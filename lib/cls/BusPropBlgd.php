<?php

/**
 * Created by PhpStorm.
 * User: cse498
 * Date: 2/17/16
 * Time: 1:01 AM
 */
class BusPropBlgd
{

    private $id;
    private $Prop_ID;

    public function __construct($row) {
        $this->id = $row['id'];
        $this->Prop_ID = $row['Prop_ID'];
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
    public function getPropID()
    {
        return $this->Prop_ID;
    }

    public function serialize() {
        $disaster = "{";
        $disaster.="\"id\":$this->id,";
        $disaster.="\"Prop_ID\":$this->Prop_ID";
        $disaster.="}";
        return $disaster;
    }

    public function __toString() {
        return $this->serialize();
    }


}