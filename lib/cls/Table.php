<?php

/**
 * Created by PhpStorm.
 * User: cse498
 * Date: 2/10/16
 * Time: 1:02 PM
 */
class Table
{
    protected $site;
    protected $tableName;

    /**
     * Constructor
     * @param Site $site
     * @param $name
     */
    public function __construct(Site $site, $name) {
        $this->site = $site;
        $this->tableName = $name;
    }

    /**
     * gets the PDO object
     * @return null|PDO
     */
    public function pdo() {
        return $this->site->pdo();
    }

    /**
     * returns table name
     * @return mixed
     */
    public function getTableName() {
        return $this->tableName;
    }

}