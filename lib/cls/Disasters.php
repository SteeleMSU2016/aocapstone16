<?php

/**
 * Created by PhpStorm.
 * User: cse498
 * Date: 2/12/16
 * Time: 2:41 AM
 */
class Disasters extends Table
{
    public function __construct(Site $site) {
        parent::__construct($site, "Disaster");
    }

    public function getDisasters() {
        $sql = <<<SQL
SELECT * FROM $this->tableName
SQL;
        $pdo = $this->pdo();
        $query = $pdo->prepare($sql);
        $query->execute();

        $result = array();
        foreach($query as $row){
            array_push($result, new Disaster($row));
        }
        return $result;

    }

    public function AddDisaster($name, $datetime, $city, $state, $polygon, $reason, $username){
        //$datetime =  date("Y-m-d H:i:s");

        $sql =<<<SQL
INSERT INTO $this->tableName (name, date, city, state, polygon, reason, createdBy)
VALUES (?,?,?,?,?,?,?)
SQL;

        $pdo = $this->pdo();
        //$pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES,TRUE);
        $statement = $pdo->prepare($sql);
        $statement->execute(array($name, $datetime, $city, $state, $polygon, $reason, $username));
        $id = $pdo->lastInsertId();
        //$pdo->commit();
        return $id;
    }

    public function DeleteDataset($id){
        $sql =<<<SQL
DELETE FROM $this->tableName
WHERE id = ?
SQL;
        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        $statement->execute(array($id));
    }

    public function getDisasterFromId($id){
        $sql = <<<SQL
SELECT * FROM $this->tableName
WHERE id = ?
SQL;
        $pdo = $this->pdo();
        $query = $pdo->prepare($sql);
        $query->execute(array($id));

        if($query->rowCount() === 0) {
            return null;
        }

        return new Disaster($query->fetch(PDO::FETCH_ASSOC));
    }

    public function updatePolygonFromId($id, $poly){
        $sql = <<<SQL
UPDATE $this->tableName
SET polygon=?
WHERE id = ?
SQL;

        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        $statement->execute(array($poly, $id));
    }
}