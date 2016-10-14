<?php

/**
 * Created by PhpStorm.
 * User: cse498
 * Date: 2/17/16
 * Time: 12:43 PM
 */
class DisasterDataset
{

    private $D_ID;
    private $P_ID;
    private $Prop_ID;

    public function __construct($row) {
        $this->D_ID = $row['D_ID'];
        $this->P_ID = $row['P_ID'];
        $this->Prop_ID = $row['Prop_ID'];
    }

    /**
     * @return mixed
     */
    public function getDID()
    {
        return $this->D_ID;
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
    public function getPropID()
    {
        return $this->Prop_ID;
    }

    public function serialize() {
        $disaster = "{";
        $disaster.="\"D_ID\":$this->D_ID,";
        $disaster.="\"P_ID\":$this->P_ID,";
        $disaster.="\"Prop_ID\":$this->Prop_ID";
        $disaster.="}";
        return $disaster;
    }

    public function __toString() {
        return $this->serialize();
    }


}