<?php
/** @file
 * @brief Empty unit testing template/database version
 * @cond 
 * @brief Unit tests for the class 
 */
require_once 'DatabaseTestBase.php';

class EmptyDBTest extends DatabaseTestBase
{
	/**
     * @return PHPUnit_Extensions_Database_DB_IDatabaseConnection
     */
    public function getConnection()
    {
        $pdo = pdo_connect();

        return $this->createDefaultDBConnection($pdo, 'auto-owners');
    }

    /**
     * @return PHPUnit_Extensions_Database_DataSet_IDataSet
     */
    public function getDataSet()
    {
        return new PHPUnit_Extensions_Database_DataSet_DefaultDataSet();

        //return $this->createFlatXMLDataSet(dirname(__FILE__) . '/db/users.xml');
    }
	
}

/// @endcond
?>
