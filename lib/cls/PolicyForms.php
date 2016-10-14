<?php

/**
 * Created by PhpStorm.
 * User: cse498
 * Date: 2/17/16
 * Time: 1:45 AM
 */
class PolicyForms extends Table
{
    /**
     * Constructor
     * @param Site $site
     */
    public function __construct(Site $site) {
        parent::__construct($site, "PolicyForm");
    }

    /**
     * returns an array of all the PolicyForms in the database
     * @return string
     */
    public function getPolicyForms()
    {
        $sql = <<<SQL
SELECT * FROM $this->tableName
SQL;
        $pdo = $this->pdo();
        $query = $pdo->prepare($sql);
        $query->execute();

        $result = "[";
        $end = $query->rowCount() - 1;
        $i = 0;
        foreach ($query as $row) {
            $policyHolder = new PolicyForm($row);
            $result .= $policyHolder->serialize();
            if ($i != $end) {
                $result .= ",";
            }
            $i += 1;
        }
        $result .= "]";
        return $result;
    }

    /**
     * returns an array of all the policy forms attached to a Policy ID integer
     * @param $P_ID
     * @return array
     */
    public function getFormsFromPolicy($P_ID) {
        $sql = <<<SQL
SELECT * FROM $this->tableName
WHERE P_ID = ?
SQL;

        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        $statement->execute(array($P_ID));

        $result = array();
        foreach($statement as $row){
            array_push($result, new PolicyForm($row));
        }
        return $result;
    }
}