<?php

/**
 * Created by PhpStorm.
 * User: cse498
 * Date: 4/7/16
 * Time: 12:54 PM
 */
class Branch
{

    private $id;
    private $name;
    private $A_ID;

    /**
     * Branch constructor.
     * @param $row
     */
    public function __construct($row) {
        $this->id = $row['id'];
        $this->name = $row['name'];
        $this->A_ID = $row['A_ID'];
    }

    /**
     * Getter to return Branch id
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Getter to return Branch Name
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Getter to return Branch's Agency id
     * @return mixed
     */
    public function getAID()
    {
        return $this->A_ID;
    }

    /**
     * Function to turn Branch Object into a JSON Object
     * @return string
     */
    public function serialize() {
        $branch = "{";
        $branch.="\"id\":$this->id,";
        $branch.="\"name\":\"$this->name\",";
        $branch.="\"A_ID\":$this->A_ID";
        $branch.="}";
        return $branch;
    }

    /**
     * Function to return the serialization of Branch
     * @return string
     */
    public function __toString() {
        return $this->serialize();
    }
}