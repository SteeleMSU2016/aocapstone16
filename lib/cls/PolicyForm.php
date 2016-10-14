<?php

/**
 * Created by PhpStorm.
 * User: cse498
 * Date: 2/17/16
 * Time: 1:21 AM
 */
class PolicyForm
{

    private $name;
    private $P_ID;

    /**
     * Creates a PolicyForm object from a database row
     * @param $row
     */
    public function __construct($row) {
        $this->name = $row['name'];
        $this->P_ID = $row['P_ID'];
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
    public function getPID()
    {
        return $this->P_ID;
    }

    /**
     * Creates a JSON string of the object
     * @return string
     */
    public function serialize() {
        $form = "{";
        $form.="\"name\":\"$this->name\",";
        $form.="\"P_ID\":$this->P_ID";
        $form.="}";
        return $form;
    }

    /**
     * Makes a comparable string from the object
     * @return string
     */
    public function __toString() {
        return $this->serialize();
    }
}