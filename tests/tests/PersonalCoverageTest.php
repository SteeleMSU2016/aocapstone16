<?php
/** @file
 * @brief Empty unit testing template
 * @cond
 * @brief Unit tests for the class
 */
class PersonalCoverageTest extends \PHPUnit_Framework_TestCase
{
    public function test1() {
        //$this->assertEquals($expected, $actual);
    }

    public function test_construct() {
        $row = array(
            'name' => 'CoverageA',
            'Prop_ID' => 1,
            'amount' => 100,
            'deductAmount' => 2300
        );

        $personalCoverage = new PersonalCoverage($row);
        $this->assertInstanceOf('PersonalCoverage', $personalCoverage);
        $this->assertEquals('CoverageA', $personalCoverage->getName());
        $this->assertEquals(1, $personalCoverage->getPropID());
        $this->assertEquals(100, $personalCoverage->getAmount());
        $this->assertEquals(2300, $personalCoverage->getDeductAmount());
    }
}

/// @endcond
?>