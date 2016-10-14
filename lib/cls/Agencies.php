<?php

/**
 * Created by PhpStorm.
 * User: cse498
 * Date: 2/12/16
 * Time: 2:21 AM
 */
class Agencies extends Table
{
    /**
     * Agencies constructor.
     * @param Site $site
     */
    public function __construct(Site $site) {
        parent::__construct($site, "Agency");
    }

    /**
     * Function to retrieve the agencies as a JSON array
     * @return string
     */
    public function getAgencies() {
        $sql = <<<SQL
SELECT * FROM $this->tableName
SQL;
        $pdo = $this->pdo();
        $query = $pdo->prepare($sql);
        $query->execute();

        /*Take result from sql query and turn into JSON Object*/
        $result = "[";
        $end = $query->rowCount() - 1;
        $i = 0;
        foreach($query as $row){
            $agency = new Agency($row);
            $result.=$agency->serialize();
            if($i != $end) {
                $result .= ",";
            }
            $i+=1;
        }
        $result.="]";
        return $result;

    }

    /**
     * Function to return a Agency based on integer Id
     * @param $id Agency ID
     * @return Agency|null
     */
    public function getAgency($id){
        $sql =<<<SQL
SELECT * FROM $this->tableName
WHERE id = ?
SQL;

        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        $statement->execute(array($id));

        /*Take result from sql query and return null or Agency object*/
        if($statement->rowCount() === 0) {
            return null;
        }

        return new Agency($statement->fetch(PDO::FETCH_ASSOC));
    }
}