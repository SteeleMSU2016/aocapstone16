<?php
/** @file
 * @brief Empty unit testing template
 * @cond 
 * @brief Unit tests for the class 
 */
class AgencyTest extends \PHPUnit_Framework_TestCase
{
	public function test1() {
		//$this->assertEquals($expected, $actual);
	}

	public function test_construct(){
		$row = array(
			'id' => 1,
			'name' => 'Auto-Owners',
			'address' => '1400 Abbot #320',
			'city' => 'East Lansing',
			'state' => 'MI',
			'zipCode' =>'48823'
		);

		$agency = new Agency($row);
		$this->assertInstanceOf('Agency', $agency);
		$this->assertEquals(1, $agency->getId());
		$this->assertEquals('Auto-Owners', $agency->getName());
		$this->assertEquals('1400 Abbot #320', $agency->getAddress());
		$this->assertEquals('East Lansing', $agency->getCity());
		$this->assertEquals('MI', $agency->getState());
		$this->assertEquals('48823', $agency->getZipCode());
	}
}

/// @endcond
?>
