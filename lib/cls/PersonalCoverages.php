<?php

/**
 * Created by PhpStorm.
 * User: cse498
 * Date: 2/17/16
 * Time: 1:42 AM
 */
class PersonalCoverages extends Table
{
    public function __construct(Site $site) {
        parent::__construct($site, "PersonalCoverage");
    }

    public function getPersonalCoverages() {
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
            $policyHolder = new PersonalCoverage($row);
            $result.=$policyHolder->serialize();
            if($i != $end) {
                $result .= ",";
            }
            $i+=1;
        }
        $result.="]";
        return $result;
    }

    public function getCoveragesFromProperty($Prop_ID) {
        $sql = <<<SQL
SELECT * FROM $this->tableName
WHERE Prop_ID = ?
SQL;

        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        $statement->execute(array($Prop_ID));

        $result = array();
        foreach($statement as $row){
            array_push($result, new PersonalCoverage($row));
        }
        return $result;
    }
}