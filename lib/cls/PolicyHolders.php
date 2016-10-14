<?php

/**
 * Created by PhpStorm.
 * User: cse498
 * Date: 2/12/16
 * Time: 2:45 AM
 */
class PolicyHolders extends Table
{
    /**
     * @param Site $site
     */
    public function __construct(Site $site) {
        parent::__construct($site, "PolicyHolder");
    }

    /**
     * returns an array of all the PolicyHolders in the database
     * @return array
     */
    public function getPolicyHolders() {
        $sql = <<<SQL
SELECT * FROM $this->tableName
SQL;
        $pdo = $this->pdo();
        $query = $pdo->prepare($sql);
        $query->execute();

        $result = array();
        foreach($query as $row){
            array_push($result, new PolicyHolder($row));
        }
        return $result;

    }

    /**
     * returns none or policyholder object based on integer id
     * @param $id
     * @return null|PolicyHolder
     */
    public function getPolicyHolder($id){
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

        return new PolicyHolder($statement->fetch(PDO::FETCH_ASSOC));
    }
}