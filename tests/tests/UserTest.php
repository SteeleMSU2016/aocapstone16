<?php
/** @file
 * @brief Empty unit testing template
 * @cond
 * @brief Unit tests for the class
 */
class UserTest extends \PHPUnit_Framework_TestCase
{
	public function test_construct() {
		$row = array(
			'username' => 'Nick',
			'security' => 3);
		$user = new User($row);
		$this->assertEquals('Nick', $user->getUsername());
		$this->assertEquals(3, $user->getSecurity());
	}

	private static $site;

	public function test_setUp() {
		self::$site = new Site();
		$localize  = require 'localize.inc.php';
		if(is_callable($localize)) {
			$localize(self::$site);
		}
		$pdo = self::$site->pdo();
		$users = new Users(self::$site);
		$this->assertInstanceOf('Users', $users);
	}
}

/// @endcond
?>
