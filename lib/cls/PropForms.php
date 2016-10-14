<?php

/**
 * Created by PhpStorm.
 * User: cse498
 * Date: 2/17/16
 * Time: 1:45 AM
 */
class PropForms extends Table
{
    /**
     * Constructor
     * @param Site $site
     */
    public function __construct(Site $site) {
        parent::__construct($site, "PropForm");
    }

    /**
     * returns a serialized JSON string of all the property forms in the database
     * @return string
     */
    public function getPropForms() {
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
            $policyHolder = new PropForm($row);
            $result.=$policyHolder->serialize();
            if($i != $end) {
                $result .= ",";
            }
            $i+=1;
        }
        $result.="]";
        return $result;

    }

    /**
     * returns an array of PropForm objects based on a property ID
     * @param $Prop_ID
     * @return array
     */
    public function getPropFormsFromProperty($Prop_ID) {
        $sql = <<<SQL
SELECT * FROM $this->tableName
WHERE Prop_ID = ?
SQL;

        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        $statement->execute(array($Prop_ID));

        $result = array();
        foreach($statement as $row){
            array_push($result, new PropForm($row));
        }

        return $result;
    }
}