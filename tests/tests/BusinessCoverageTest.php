<?php
/** @file
 * @brief Empty unit testing template
 * @cond
 * @brief Unit tests for the class
 */
class BusinessCoverageTest extends \PHPUnit_Framework_TestCase
{
    public function test1() {
        //$this->assertEquals($expected, $actual);
    }

    public function test_construct() {
        $row = array(
            'name' => 'CoverageA',
            'Prop_ID' => 1,
            'Blgd_ID' => 1,
            'amount' => 100,
            'deductAmount' => 2300
        );

        $businessCoverage = new BusinessCoverage($row);
        $this->assertInstanceOf('BusinessCoverage', $businessCoverage);
        $this->assertEquals('CoverageA', $businessCoverage->getName());
        $this->assertEquals(1, $businessCoverage->getPropID());
        $this->assertEquals(1, $businessCoverage->getBlgdID());
        $this->assertEquals(100, $businessCoverage->getAmount());
        $this->assertEquals(2300, $businessCoverage->getDeductAmount());
    }
}

/// @endcond
?>