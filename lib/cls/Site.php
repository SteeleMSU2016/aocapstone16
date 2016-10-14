<?php

/**
 * Created by PhpStorm.
 * User: cse498
 * Date: 1/30/16
 * Time: 10:09 AM
 */
class Site {
    // Getters and Setters
    /**
     * returns root of the website
     * @return string
     */
    public function getRoot() { return $this->root; }

    /**
     * sets the root of the website
     * @param $root
     */
    public function setRoot($root) { $this->root = $root; }

    /**
     * sets up the database connection
     * @param $host
     * @param $user
     * @param $password
     */
    public function dbConfigure($host, $user, $password){
        $this->dbHost = $host;
        $this->dbUser = $user;
        $this->dbPassword = $password;
    }

    /**
     * creates the PDO object
     * @return null|PDO
     */
    function pdo(){
        // This ensures we only create the PDO object once
        if($this->pdo !== null){
            return $this->pdo;
        }

        try{
            $this->pdo = new PDO($this->dbHost, $this->dbUser, $this->dbPassword);
        } catch(PDOException $e){
            // If we can't connect we die!
            die("Unable to select database");
        }

        return $this->pdo;
    }

    private $root = '';           ///< Site root
    private $dbHost = null;       ///< Datebase host name
    private $dbUser = null;       ///< Database user name
    private $dbPassword = null;   ///< Database Password
    private $pdo = null;          ///< The PDO object
}