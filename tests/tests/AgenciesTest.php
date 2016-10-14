<?php
/** @file
 * @brief Empty unit testing template/database version
 * @cond
 * @brief Unit tests for the class
 */

class AgenciesTest extends \PHPUnit_Extensions_Database_TestCase
{
    // IMPORTANT : overload getSetUpOperation and add "TRUE" parameter to CLEAN_INSERT()
    /*protected function getSetUpOperation() {
        return PHPUnit_Extensions_Database_Operation_Factory::CLEAN_INSERT(TRUE);
    }*/

    /**
     * @return \PHPUnit_Extensions_Database_Operation
     */
    protected function getSetUpOperation() {
        return new \PHPUnit_Extensions_Database_Operation_Composite(array(
            \PHPUnit_Extensions_Database_Operation_Factory::DELETE_ALL(),
            \PHPUnit_Extensions_Database_Operation_Factory::INSERT()
        ));
    }

    /**
     * @return PHPUnit_Extensions_Database_DB_IDatabaseConnection
     */
    public function getConnection()
    {
        return $this->createDefaultDBConnection(self::$site->pdo(), 'auto-owners');
    }

    /**
     * @return PHPUnit_Extensions_Database_DataSet_IDataSet
     */
    public function getDataSet()
    {
        return $this->createFlatXMLDataSet(dirname(__FILE__) . '/db/agency.xml');
    }

    public function test_empty() {
        $this->assertEquals(1,1);
    }

    private static $site;

    public static function setUpBeforeClass() {
        self::$site = new Site();
        $localize  = require 'localize.inc.php';
        if(is_callable($localize)) {
            $localize(self::$site);
        }
    }

    /*public function test_construct() {
        $agencies = new Agencies(self::$site);
        $this->assertInstanceOf('Agencies', $agencies);
    }*/

}

/// @endcond
?>
