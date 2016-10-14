<?php

/**
 * Created by PhpStorm.
 * User: cse498
 * Date: 2/18/16
 * Time: 1:59 PM
 */
class Vehicles extends Table
{

    public function __construct(Site $site) {
        parent::__construct($site, "Vehicle");
    }

    public function getAllVehicles() {
        $sql = <<<SQL
SELECT * FROM $this->tableName
SQL;

        $pdo = $this->pdo();
        $query = $pdo->prepare($sql);
        $query->execute();

        $result = "[";
        $end = $query->rowCount() - 1;
        $i = 0;
        foreach($query as $row){
            $policyHolder = new Vehicle($row);
            $result.=$policyHolder->serialize();
            if($i != $end) {
                $result .= ",";
            }
            $i+=1;
        }
        $result.="]";
        return $result;
    }

    public function getVehicle($id){
        $sql = <<<SQL
SELECT * FROM $this->tableName
WHERE id = ?
SQL;
        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        $statement->execute(array($id));

        if($statement->rowCount() === 0) {
            return null;
        }

        return new Vehicle($statement->fetch(PDO::FETCH_ASSOC));
    }

    public function getVehiclesFromPolicy($p_id) {
        $sql = <<<SQL
SELECT * FROM $this->tableName
WHERE P_ID = ?
SQL;

        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        $statement->execute(array($p_id));

        $result = array();
        foreach($statement as $row){
            array_push($result, new Vehicle($row));
        }
        return $result;
    }
}