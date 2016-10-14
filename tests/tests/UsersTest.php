<?php
/** @file
 * @brief Empty unit testing template/database version
 * @cond
 * @brief Unit tests for the class
 */

class UsersTest extends \PHPUnit_Extensions_Database_TestCase
{
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
        return $this->createFlatXMLDataSet(dirname(__FILE__) . '/db/user.xml');
    }

    //public fuction test_empty()

    private static $site;

    public static function setUpBeforeClass() {
        self::$site = new Site();
        $localize  = require 'localize.inc.php';
        if(is_callable($localize)) {
            $localize(self::$site);
        }
    }

    public function test_construct() {
        $users = new Users(self::$site);
        $this->assertInstanceOf('Users', $users);
    }

    public function test_login() {
        $users = new Users(self::$site);

        // Test a valid login based on user ID
        $user = $users->login("Nick", "Test");
        $this->assertInstanceOf("User", $user);
        $this->assertEquals('Nick', $user->getUsername());
        $this->assertEquals(3, $user->getSecurity());


        // Test a failed login
        $user = $users->login("Nick", "wrongpw");
        $this->assertNull($user);
    }

}

/// @endcond
?>
