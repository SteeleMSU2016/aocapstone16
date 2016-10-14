<?php
/** @file
 * @brief Empty unit testing template
 * @cond
 * @brief Unit tests for the class
 */
class BusPropBldgTest extends \PHPUnit_Framework_TestCase
{
    public function test1() {
        //$this->assertEquals($expected, $actual);
    }

    public function test_construct() {
        $row = array(
            'id' => 1,
            'Prop_ID' => 1
        );

        $busPropBlgd = new BusPropBlgd($row);
        $this->assertInstanceOf('BusPropBlgd', $busPropBlgd);
        $this->assertEquals(1, $busPropBlgd->getID());
        $this->assertEquals(1, $busPropBlgd->getPropID());
    }
}

/// @endcond
?>