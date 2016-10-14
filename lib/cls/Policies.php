<?php

/**
 * Created by PhpStorm.
 * User: cse498
 * Date: 2/12/16
 * Time: 2:11 AM
 */
class Policies extends Table
{
    /**
     * constructor for Policies
     * @param Site $site
     */
    public function __construct(Site $site) {
        parent::__construct($site, "Policy");
    }

    /**
     * Function to retrieve the policies as a JSON array
     * @return string
     */
    public function getPolicies() {
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
            $policy = new Policy($row);
            $result.=$policy->serialize();
            if($i != $end) {
                $result .= ",";
            }
            $i+=1;
        }
        $result.="]";
        return $result;

    }

    /**
     * Function to return a Policy based on integer Id
     * @param $id
     * @return null|Policy
     */
    public function getPolicy($id){
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

        return new Policy($statement->fetch(PDO::FETCH_ASSOC));
    }

    /**
     * Function to return an array of Policy Objects based on a policy holder Id integer
     * @param $PH_ID
     * @return array
     */
    public function getPoliciesFromPolicyHolder($PH_ID){
        $sql = <<<SQL
SELECT * FROM $this->tableName
WHERE PH_ID = ?
SQL;
        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        $statement->execute(array($PH_ID));

        $result = array();
        foreach($statement as $row){
            array_push($result, new Policy($row));
        }
        return $result;
    }

}