<?php

/**
 * Created by PhpStorm.
 * User: cse498
 * Date: 2/9/16
 * Time: 3:36 PM
 */
class Users extends Table
{
    /**
     * Constructor
     * @param Site $site
     */
    public function __construct(Site $site) {
        parent::__construct($site, "User");
    }

    /**
     * Compares the username and password to the database and returns null or user depending on result
     * @param $user
     * @param $password
     * @return null|User
     */
    public function login($user, $password) {
        $sql =<<<SQL
SELECT * FROM $this->tableName
WHERE BINARY username = BINARY ? AND BINARY password = BINARY ?
SQL;
        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);

        $statement->execute(array($user, $password));
        if($statement->rowCount() === 0) {
            return null;
        }

        return new User($statement->fetch(PDO::FETCH_ASSOC));
    }

    /**
     * returns the username of the user
     * @param $username
     * @return null|User
     */
    public function getUser($username) {
        $sql =<<<SQL
SELECT * FROM $this->tableName
WHERE username = ?
SQL;

        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        $statement->execute(array($username));

        if($statement->rowCount() === 0) {
            return null;
        }

        return new User($statement->fetch(PDO::FETCH_ASSOC));
    }

    /**
     * returns a JSON string of all the users in the database
     * @return string
     */
    public function getAllUsers() {
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
            $policyHolder = new User($row);
            $result.=$policyHolder->serialize();
            if($i != $end) {
                $result .= ",";
            }
            $i+=1;
        }
        $result.="]";
        return $result;
    }

}