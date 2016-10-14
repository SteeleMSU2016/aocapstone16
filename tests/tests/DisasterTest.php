<?php
/** @file
 * @brief Empty unit testing template
 * @cond
 * @brief Unit tests for the class
 */
class DisasterTest extends \PHPUnit_Framework_TestCase
{
    public function test1() {
        //$this->assertEquals($expected, $actual);
    }

    public function test_construct() {
        $row = array(
            'id' => 1,
            'name' => 'Tornado',
            'date' => '2016-02-17 00:00:00',
            'city' => 'East Lansing',
            'state' => 'MI',
        );

        $disaster = new Disaster($row);
        $this->assertInstanceOf('Disaster', $disaster);
        $this->assertEquals(1, $disaster->getId());
        $this->assertEquals('Tornado', $disaster->getName());
        $this->assertEquals('2016-02-17 00:00:00', $disaster->getDate());
        $this->assertEquals('East Lansing', $disaster->getCity());
        $this->assertEquals('MI', $disaster->getState());
    }
}

/// @endcond
?>