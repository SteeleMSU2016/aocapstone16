<?php
/** @file
 * @brief Empty unit testing template
 * @cond
 * @brief Unit tests for the class
 */
class VehicleTest extends \PHPUnit_Framework_TestCase
{
    public function test1() {
        //$this->assertEquals($expected, $actual);
    }

    public function test_construct(){
        $row = array(
            'id' => 1,
            'P_ID' => 4,
            'make' => 'Chevrolet',
            'model' => 'Cruze',
            'year' => '2016',
            'vinNumber' => '12345678987654321'
        );

        $vehicle = new Vehicle($row);
        $this->assertInstanceOf('Vehicle', $vehicle);
        $this->assertEquals(1, $vehicle->getId());
        $this->assertEquals(4, $vehicle->getPID());
        $this->assertEquals('Chevrolet', $vehicle->getMake());
        $this->assertEquals('Cruze', $vehicle->getModel());
        $this->assertEquals('2016', $vehicle->getYear());
        $this->assertEquals('12345678987654321', $vehicle->getVinNumber());
    }
}

/// @endcond
?>