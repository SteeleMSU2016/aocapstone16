<?php

/**
 * Created by PhpStorm.
 * User: cse498
 * Date: 2/17/16
 * Time: 1:44 AM
 */
class PersonalClaims extends Table
{
    public function __construct(Site $site) {
        parent::__construct($site, "PersonalClaim");
    }

    public function getPersonalClaims() {
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
            $policyHolder = new PersonalClaim($row);
            $result.=$policyHolder->serialize();
            if($i != $end) {
                $result .= ",";
            }
            $i+=1;
        }
        $result.="]";
        return $result;
    }

    public function getPersonalClaim($id){
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

        return new PersonalClaim($statement->fetch(PDO::FETCH_ASSOC));
    }

    public function getPersonalClaimsfromPolicy($P_ID){
        $sql =<<<SQL
SELECT * FROM $this->tableName
WHERE P_ID = ?
SQL;

        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        $statement->execute(array($P_ID));

        $result = array();
        foreach($statement as $row){
            array_push($result, new PersonalClaim($row));
        }
        return $result;
    }

    public function getPersonalClaimsfromProperty($Prop_ID){
        $sql =<<<SQL
SELECT * FROM $this->tableName
WHERE Prop_ID = ?
SQL;

        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        $statement->execute(array($Prop_ID));

        $result = array();
        foreach($statement as $row){
            array_push($result, new PersonalClaim($row));
        }
        return $result;
    }

    public function updatePersonalClaims($row){
        $sql =<<<SQL
REPLACE INTO $this->tableName
(P_ID, Prop_ID, D_ID, contentDamage, dwellingDamage, otherDamage, floodInsurance, floodInsurer, notes, U_USERNAME, status, date)
VALUES (?,?,?,?,?,?,?,?,?,?,?,?)
SQL;

        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);

        $statement->execute(array($row['p_id'], $row['prop_id'], $row['d_id'], $row['contentDamage'], $row['dwellingDamage'], $row['otherDamage'], $row['floodInsurance'], $row['floodInsurer'], $row['notes'], $row['u_username'], $row['status'], $row['date']));
    }

    public function getPersonalClaimsfromDisaster($D_ID){
        $sql =<<<SQL
SELECT * FROM $this->tableName
WHERE D_ID = ?
SQL;

        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        $statement->execute(array($D_ID));

        $result = array();
        foreach($statement as $row){
            array_push($result, new PersonalClaim($row));
        }
        return $result;
    }

    public function getPersonalClaimsfromPropertyAndDisaster($Prop_ID, $D_ID){
        $sql =<<<SQL
SELECT * FROM $this->tableName
WHERE Prop_ID = ? and D_ID = ?
SQL;

        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        $statement->execute(array($Prop_ID, $D_ID));

        $result = array();
        foreach($statement as $row){
            array_push($result, new PersonalClaim($row));
        }
        return $result;
    }

    public function countPersonalClaimsAgency($d_id){
        //$personalClaims = new PersonalClaims($this->site);
        //$personalClaimsTable = $personalClaims->getTableName();
        $polices = new Policies($this->site);
        $agencies = new Agencies($this->site);
        $agencyTable = $agencies->getTableName();
        $policyTable = $polices->getTableName();

        $sql =<<<SQL
SELECT agency.name, COUNT(*)
FROM $this->tableName personal, $policyTable policy, $agencyTable agency
WHERE personal.D_ID = ? AND personal.P_ID = policy.id AND policy.A_ID = agency.id
GROUP BY agency.name
ORDER BY agency.name
SQL;

        /*$sql =<<<SQL
SELECT agency.name, COUNT(*)
FROM (`BusinessClaim`  INNER JOIN `PersonalClaim` ON `BusinessClaim`.D_ID = `PersonalClaim`.D_ID AND `PersonalClaim`.P_ID = `BusinessClaim`.P_ID) claim,
`Policy` policy, `Agency` agency
WHERE claim.D_ID = 1 AND claim.P_ID = policy.id AND policy.A_ID = agency.id
GROUP BY agency.name
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

    public function countPersonalClaimsDay($d_id){
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

    public function countCity($d_id){
        $properties = new Properties($this->site);
        $propTable = $properties->getTableName();

        $sql =<<<SQL
SELECT COUNT(*), prop.city
FROM $this->tableName personal, $propTable prop
WHERE personal.D_ID = ? AND personal.Prop_ID = prop.id
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

    public function countState($d_id){
        $properties = new Properties($this->site);
        $propTable = $properties->getTableName();

        $sql =<<<SQL
SELECT COUNT(*), prop.state
FROM $this->tableName personal, $propTable prop
WHERE personal.D_ID = ? AND personal.Prop_ID = prop.id
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

    public function countStatus($d_id){
        $sql =<<<SQL
SELECT COUNT(*), status
FROM $this->tableName
WHERE D_ID = ?
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

    public function countBranch($d_id){
        $branches = new Branches($this->site);
        $branchTable = $branches->getTableName();
        $users = new Users($this->site);
        $userTable = $users->getTableName();

        $sql =<<<SQL
SELECT branch.name, COUNT(*)
FROM $this->tableName bus, $userTable user, $branchTable branch
WHERE bus.D_ID = ? AND bus.U_USERNAME = user.username AND AND user.B_ID = branch.id
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
            //$statement->fetch(PDO::FETCH_ASSOC)
        }

        return $claims;
    }

    public function updatePersonalClaim($id, $row){
        $sql = <<<SQL
UPDATE $this->tableName
SET D_ID = ?,contentDamage = ?,dwellingDamage = ?,otherDamage = ?,floodInsurance = ?,floodInsurer = ?,U_USERNAME = ?,status = ?, date = ?
WHERE id = ?
SQL;
        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        $statement->execute(array($row['disaster'], $row['contentDamage'],$row['dwellingDamage'],$row['otherDamage'],$row['floodInsurance'],$row['floodInsurer'],$row['username'],$row['status'],$row['date'], $id));
    }

}