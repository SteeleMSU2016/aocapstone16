<?php

/**
 * Created by PhpStorm.
 * User: cse498
 * Date: 2/17/16
 * Time: 1:44 AM
 */
class BusinessClaims extends Table
{
    protected $site;

    /**
     * BusinessClaims constructor.
     * @param Site $site
     */
    public function __construct(Site $site) {
        $this->site = $site;
        parent::__construct($site, "BusinessClaim");
    }

    /**
     * Function to retrieve the Business Claims as a JSON array
     * @return string
     */
    public function getBusinessClaims() {
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
            $policyHolder = new BusinessClaim($row);
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
     * Function to return a Business Claim based on integer Id
     * @param $id Business Claim id
     * @return BusinessClaim|null
     */
    public function getBusinessClaim($id){
        $sql =<<<SQL
SELECT * FROM $this->tableName
WHERE id = ?
SQL;

        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        $statement->execute(array($id));

        if($statement->rowCount() === 0) {
            return null;
        }

        return new BusinessClaim($statement->fetch(PDO::FETCH_ASSOC));
    }

    /**
     * Function to return array of Business Claims based on a Policy ID
     * @param $P_ID Policy ID
     * @return array
     */
    public function getBusinessClaimsfromPolicy($P_ID){
        $sql =<<<SQL
SELECT * FROM $this->tableName
WHERE P_ID = ?
SQL;

        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        $statement->execute(array($P_ID));

        $result = array();
        foreach($statement as $row){
            array_push($result, new BusinessClaim($row));
        }
        return $result;
    }

    /**
     * Function to return array of Business Claims based on a Property ID and Disaster ID
     * @param $Prop_ID Property ID
     * @param $D_ID Disaster ID
     * @return array
     */
    public function getBusinessClaimsfromPropertyAndDisaster($Prop_ID, $D_ID){
        $sql =<<<SQL
SELECT * FROM $this->tableName
WHERE Prop_ID = ? and D_ID = ?
SQL;

        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        $statement->execute(array($Prop_ID, $D_ID));

        $result = array();
        foreach($statement as $row){
            array_push($result, new BusinessClaim($row));
        }
        return $result;
    }

    /**
     * Function to return array of Business Claims based on a Property ID
     * @param $Prop_ID Property ID
     * @return array
     */
    public function getBusinessClaimsfromProperty($Prop_ID){
        $sql =<<<SQL
SELECT * FROM $this->tableName
WHERE Prop_ID = ?
SQL;

        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        $statement->execute(array($Prop_ID));

        $result = array();
        foreach($statement as $row){
            array_push($result, new BusinessClaim($row));
        }
        return $result;
    }

    /**
     * Function to update a Business claim
     * @param $row
     */
    public function updateBusinessClaims($row){
        $sql =<<<SQL
REPLACE INTO $this->tableName
(P_ID, Prop_ID, D_ID, contentDamage, dwellingDamage, floodInsurance, floodInsurer, notes, U_USERNAME, status, date)
VALUES (?,?,?,?,?,?,?,?,?,?,?)
SQL;

        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);

        $statement->execute(array($row['p_id'], $row['prop_id'], $row['d_id'], $row['contentDamage'], $row['dwellingDamage'], $row['floodInsurance'], $row['floodInsurer'], $row['notes'], $row['u_username'], $row['status'], $row['date']));
    }

    /**
     * Function to return an array of Business Claims based on a disaster id
     * @param $D_ID
     * @return array
     */
    public function getBusinessClaimsfromDisaster($D_ID){
        $sql =<<<SQL
SELECT * FROM $this->tableName
WHERE D_ID = ?
SQL;

        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        $statement->execute(array($D_ID));

        $result = array();
        foreach($statement as $row){
            array_push($result, new BusinessClaim($row));
        }
        return $result;
    }

    /**
     * Function to return a count of Business Claims by Agency for a disaster
     * @param $d_id
     * @return array|null
     */
    public function countBusClaimsAgency($d_id){
        //$personalClaims = new PersonalClaims($this->site);
        //$personalClaimsTable = $personalClaims->getTableName();
        $polices = new Policies($this->site);
        $agencies = new Agencies($this->site);
        $agencyTable = $agencies->getTableName();
        $policyTable = $polices->getTableName();

        $sql =<<<SQL
SELECT agency.name, COUNT(*)
FROM $this->tableName bus, $policyTable policy, $agencyTable agency
WHERE bus.D_ID = ? AND bus.P_ID = policy.id AND policy.A_ID = agency.id
GROUP BY agency.name
ORDER BY agency.name
SQL;

        /*$sql =<<<SQL
SELECT agency.name, COUNT(*)
FROM `Policy` policy, `Agency` agency,
(SELECT * FROM `BusinessClaim` INNER JOIN `PersonalClaim` per ON `BusinessClaim`.D_ID = per.D_ID INNER JOIN `PersonalClaim` pers ON `BusinessClaim`.P_ID = pers.P_ID) AS claim
WHERE claim.D_ID = 45  AND claim.P_ID = policy.id AND policy.A_ID = agency.id
GROUP BY agency.name
ORDER BY agency.name
SQL;*/


        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        $statement->execute(array($d_id));

        if($statement->rowCount() === 0) {
            return null;
        }

        $claims = array();
        foreach ($statement as $row){
            $claim = array($row['name'], (int)$row['COUNT(*)']);
            array_push($claims, $claim);
            //$statement->fetch(PDO::FETCH_ASSOC)
        }

        return $claims;

    }

    /**
     * Function to return a count of Business Claims by Date for a disaster
     * @param $d_id
     * @return array|null
     */
    public function countBusClaimsDay($d_id){
        $sql =<<<SQL
SELECT COUNT(*), DATE(date)
FROM $this->tableName
WHERE date >= (CURDATE( ) - INTERVAL 10 DAY ) AND D_ID = ?
GROUP BY DATE( date )
LIMIT 0, 30
SQL;
        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        $statement->execute(array($d_id));

        if($statement->rowCount() === 0) {
            return null;
        }

        $claims = array();
        foreach($statement as $row){
            $claim = array($row['DATE(date)'], (int)$row['COUNT(*)']);
            array_push($claims, $claim);
        }

        return $claims;
    }

    /**
     * Function to return a count of Business Claims by Property Type for a disaster
     * @param $d_id
     * @return mixed|null
     */
    public function countPropType($d_id){
        $sql =<<<SQL
SELECT COUNT(*)
FROM $this->tableName
WHERE D_ID = ?
SQL;
        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        $statement->execute(array($d_id));

        if($statement->rowCount() === 0) {
            return null;
        }

        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Function to return a count of Business Claims by City for a disaster
     * @param $d_id
     * @return array|null
     */
    public function countCity($d_id){
        $properties = new Properties($this->site);
        $propTable = $properties->getTableName();

        $sql =<<<SQL
SELECT COUNT(*), prop.city
FROM $this->tableName bus, $propTable prop
WHERE bus.D_ID = ? AND bus.Prop_ID = prop.id
GROUP BY prop.city
ORDER BY prop.city
SQL;
        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        $statement->execute(array($d_id));

        if($statement->rowCount() === 0) {
            return null;
        }

        $claims = array();
        foreach($statement as $row){
            $claim = array($row['city'], (int)$row['COUNT(*)']);
            array_push($claims, $claim);
        }

        return $claims;
    }

    /**
     * Function to return a count of Business Claims by State for a disaster
     * @param $d_id
     * @return array|null
     */
    public function countState($d_id){
        $properties = new Properties($this->site);
        $propTable = $properties->getTableName();

        $sql =<<<SQL
SELECT COUNT(*), prop.state
FROM $this->tableName bus, $propTable prop
WHERE bus.D_ID = ? AND bus.Prop_ID = prop.id
GROUP BY prop.state
ORDER BY prop.state
SQL;
        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        $statement->execute(array($d_id));

        if($statement->rowCount() === 0) {
            return null;
        }

        $claims = array();
        foreach($statement as $row){
            $claim = array($row['state'], (int)$row['COUNT(*)']);
            array_push($claims, $claim);
        }

        return $claims;
    }

    /**
     * Function to return a count of Business Claims by Adjuster for a disaster
     * @param $d_id
     * @return array|null
     */
    public function countAdjuster($d_id){
        $sql =<<<SQL
SELECT COUNT(*), U_USERNAME
FROM $this->tableName bus
WHERE bus.D_ID = ?
GROUP BY U_USERNAME
ORDER BY U_USERNAME
SQL;
        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        $statement->execute(array($d_id));

        if($statement->rowCount() === 0) {
            return null;
        }

        $claims = array();
        foreach($statement as $row){
            $claim = array($row['U_USERNAME'], (int)$row['COUNT(*)']);
            array_push($claims, $claim);
        }

        return $claims;
    }

    /**
     * Function to return a count of Business Claims by Status for a disaster
     * @param $d_id
     * @return array|null
     */
    public function countStatus($d_id){
        $sql =<<<SQL
SELECT COUNT(*), status
FROM $this->tableName bus
WHERE bus.D_ID = ?
GROUP BY status
ORDER BY status
SQL;
        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        $statement->execute(array($d_id));

        if($statement->rowCount() === 0) {
            return null;
        }

        $claims = array();

        foreach($statement as $row){
            if($row['status'] == 0){
                $claim = array('New', (int)$row['COUNT(*)']);
                array_push($claims, $claim);
            }
            else if($row['status'] == 1){
                $claim = array('Assigned', (int)$row['COUNT(*)']);
                array_push($claims, $claim);
            }
            else if($row['status'] == 2){
                $claim = array('Closed', (int)$row['COUNT(*)']);
                array_push($claims, $claim);
            }
        }

        return $claims;
    }

    /**
     * Function to return a count of Business Claims by Branch for a disaster
     * @param $d_id
     * @return array|null
     */
    public function countBranch($d_id){
        $branches = new Branches($this->site);
        $branchTable = $branches->getTableName();
        $users = new Users($this->site);
        $userTable = $users->getTableName();

        $sql =<<<SQL
SELECT branch.name, COUNT(*)
FROM $this->tableName bus, $userTable user, $branchTable branch
WHERE bus.D_ID = ? AND bus.U_USERNAME = user.username AND user.B_ID = branch.id
GROUP BY branch.name
ORDER BY branch.name
SQL;


        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        $statement->execute(array($d_id));

        if($statement->rowCount() === 0) {
            return null;
        }

        $claims = array();
        foreach ($statement as $row){
            $claim = array($row['name'], (int)$row['COUNT(*)']);
            array_push($claims, $claim);
        }

        return $claims;
    }

    /**
     * @param $id
     * @param $row
     */
    public function updateBusinessClaim($id, $row){
        $sql = <<<SQL
UPDATE $this->tableName
SET D_ID = ?,contentDamage = ?,dwellingDamage = ?,floodInsurance = ?,floodInsurer = ?,U_USERNAME = ?,status = ?, date = ?
WHERE id = ?
SQL;
        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        $statement->execute(array($row['disaster'], $row['contentDamage'],$row['dwellingDamage'],$row['floodInsurance'],$row['floodInsurer'],$row['username'],$row['status'],$row['date'], $id));
    }
}