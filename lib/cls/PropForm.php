<?php

/**
 * Created by PhpStorm.
 * User: cse498
 * Date: 2/17/16
 * Time: 1:38 AM
 */
class PropForm
{

    private $name;
    private $Prop_ID;

    /**
     * Constructor
     * @param $row
     */
    public function __construct($row) {
        $this->name = $row['name'];
        $this->Prop_ID = $row['Prop_ID'];
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
     * returns a serialized JSON string of the object
     * @return string
     */
    public function serialize() {
        $form = "{";
        $form.="\"name\":\"$this->name\",";
        $form.="\"Prop_ID\":$this->Prop_ID";
        $form.="}";
        return $form;
    }

    /**
     * allows the object to be used as a string
     * @return string
     */
    public function __toString() {
        return $this->serialize();
    }


}