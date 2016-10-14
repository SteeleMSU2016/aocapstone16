<?php
/** @file
 * @brief Empty unit testing template
 * @cond
 * @brief Unit tests for the class
 */
class PropertyTest extends \PHPUnit_Framework_TestCase
{
    public function test1() {
        //$this->assertEquals($expected, $actual);
    }

    public function test_construct(){
        $row = array(
            'id' => 1,
            'P_ID' => 1,
            'address' => '1400 Abbot #320',
            'city' => 'East Lansing',
            'state' => 'MI',
            'zipCode' => '48823',
            'propType' =>  0,
        );

        $property = new Property($row);
        $this->assertInstanceOf('Property', $property);
        $this->assertEquals(1, $property->getId());
        $this->assertEquals(1, $property->getPID());
        $this->assertEquals('1400 Abbot #320', $property->getAddress());
        $this->assertEquals('East Lansing', $property->getCity());
        $this->assertEquals('MI', $property->getState());
        $this->assertEquals('48823', $property->getZipCode());
        $this->assertEquals(0, $property->getPropType());
    }
}

/// @endcond
?>