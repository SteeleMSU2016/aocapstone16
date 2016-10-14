<?php

/**
 * Created by PhpStorm.
 * User: cse498
 * Date: 2/9/16
 * Time: 3:38 PM
 */
class User
{
    //Private member variables (idk if these are what we will want)
    private $username;
    private $password;
    private $security;
    private $B_ID;

    /**
     * Constructor
     * @param $row
     */
    public function __construct($row) {
        $this->username = $row['username'];
        if(isset($row['password'])) {
            $this->password = $row['password'];
        }
        $this->security = $row['security'];
        $this->B_ID = $row['B_ID'];
    }

    /**
     * @return mixed
     */
    public function getUsername() {
        return $this->username;
    }

    /**
     * @return mixed
     */
    public function getSecurity() {
        return $this->security;
    }

    /**
     * @return mixed
     */
    public function getAID() {
        return $this->B_ID;
    }

    /**
     * Returns Serialized JSON string
     * @return string
     */
    public function serialize() {
        $form = "{";
        $form.="\"username\":\"$this->username\",";
        $form.="\"password\":\"$this->password\",";
        $form.="\"security\":$this->security,";
        $form.="\"B_ID\":$this->B_ID";
        $form.="}";
        return $form;
    }

    /**
     * returns object as string
     * @return string
     */
    public function __toString() {
        return $this->serialize();
    }

}