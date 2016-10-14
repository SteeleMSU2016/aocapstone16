<?php

/**
 * Created by PhpStorm.
 * User: cse498
 * Date: 2/17/16
 * Time: 12:44 PM
 */
class DisasterDatasets extends Table
{

    public function __construct(Site $site) {
        parent::__construct($site, "DisasterDataset");
    }

    public function getDisasterPolicyCombo() {
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
            $policyHolder = new DisasterDataset($row);
            $result.=$policyHolder->serialize();
            if($i != $end) {
                $result .= ",";
            }
            $i+=1;
        }
        $result.="]";
        return $result;
    }

    public function getDatasetFromDisaster($disaster) {
        $sql = <<<SQL
SELECT * FROM $this->tableName
WHERE D_ID = $disaster
SQL;
        $pdo = $this->pdo();
        $query = $pdo->prepare($sql);
        $query->execute();

        $result = array();
        foreach($query as $row) {
            $combo = new DisasterDataset($row);
            array_push($result, $combo);
        }

        return $result;
    }

    /*public function getDisasterPolicies($disaster) {
        $pdo = $this->pdo();
        $query = $pdo->prepare("SELECT P_ID FROM $this->tableName WHERE D_ID = $disaster");
        $query->execute();
        $result = "[";
        foreach($query as $Disaster_Policy){
            $P_ID = $Disaster_Policy['P_ID'];
            $properties = $pdo->prepare("SELECT * FROM Property WHERE P_ID = $P_ID");
            $properties->execute();
            $end = $properties->rowCount() - 1;
            $i = 0;
            foreach($properties as $row){
                $set = new Property($row);
                $result.=$set->serialize();
                if($i != $end) {
                    $result.=",";
                }
            }
        }
        $result.="]";
        return $result;
    }*/

    public function AddDataset($D_ID, $policyIDs){

        foreach($policyIDs as $P_ID){
            $sql =<<<SQL
INSERT INTO $this->tableName (D_ID, P_ID)
VALUES (?,?)
SQL;
            $pdo = $this->pdo();
            $statement = $pdo->prepare($sql);
            $statement->execute(array($D_ID, $P_ID));
        }
    }

    public function AddToDataset($D_ID, $input){
        $sql =<<<SQL
INSERT INTO $this->tableName (D_ID, P_ID, Prop_ID)
VALUES
SQL;
        $params = array();
        foreach($input as $row){
            $sql.="(?,?,?), ";
            array_push($params, $D_ID);
            array_push($params, $row['P_ID']);
            array_push($params, $row['id']);
        }
        $sql = rtrim($sql, ", ");
        $sql.=";";
        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        echo $sql;
        $statement->execute($params);
    }

    public function DeleteFromDataset($P_ID){
        $sql =<<<SQL
DELETE FROM $this->tableName
WHERE P_ID = ?
SQL;
        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        $statement->execute(array($P_ID));
    }

    public function DeleteDisasterFromDataset($D_ID){
        $sql =<<<SQL
DELETE FROM $this->tableName
WHERE D_ID = ?
SQL;
        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        $statement->execute(array($D_ID));
    }

    public function DeleteDatasetPolicies($D_ID, $policyIDs){
        foreach($policyIDs as $P_ID){
            $sql =<<<SQL
DELETE FROM $this->tableName
WHERE D_ID = ? AND P_ID = ?
SQL;
            $pdo = $this->pdo();
            $statement = $pdo->prepare($sql);
            $statement->execute(array($D_ID, $P_ID));
        }
    }

    public function DeleteDataset($D_ID){
        $sql =<<<SQL
DELETE FROM $this->tableName
WHERE D_ID =?
SQL;
        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        $statement->execute(array($D_ID));
    }

    public function getPropertyIdsFromDisaster($d_id){
        $sql = <<<SQL
SELECT Prop_ID FROM $this->tableName
WHERE D_ID = ?
SQL;
        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        $statement->execute(array($d_id));

        $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
        return $result;
    }
}