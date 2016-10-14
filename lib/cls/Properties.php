<?php

/**
 * Created by PhpStorm.
 * User: cse498
 * Date: 2/17/16
 * Time: 1:41 AM
 */
class Properties extends Table
{
    /**
     * Constructor
     * @param Site $site
     */
    public function __construct(Site $site) {
        parent::__construct($site, "Property");
    }

    /**
     * returns a serialized JSON string of all the properties in the database
     * @return string
     */
    public function getProperties() {
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
            $property = new Property($row);
            $result.=$property->serialize();
            if($i != $end) {
                $result .= ",";
            }
            $i+=1;
        }
        $result.="]";
        return $result;

    }

    /**
     * returns property object from property ID
     * @param $id
     * @return null|Property
     */
    public function getProperty($id){
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

        return new Property($statement->fetch(PDO::FETCH_ASSOC));
    }

    public function getOwner($address) {
        $sql =<<<SQL
SELECT
SQL;
    }

    /**
     * returns array of properties based on policy ID
     * @param $p_id
     * @return array
     */
    public function getPropertiesFromPolicy($p_id){
        $sql = <<<SQL
SELECT * FROM $this->tableName
WHERE P_ID = ?
SQL;

        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        $statement->execute(array($p_id));

        $result = array();
        foreach($statement as $row){
            array_push($result, new Property($row));
        }
        return $result;

    }

    /**
     * Updates the lat and lon of the specified property
     * @param $id
     * @param $lat
     * @param $lng
     */
    public function updateLatLngFromId($id, $lat, $lng){
        $sql = <<<SQL
UPDATE $this->tableName
SET lat=?,lng=?
WHERE id = ?
SQL;

        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        $statement->execute(array($lat, $lng, $id));
    }
}