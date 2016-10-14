<?php
/** @file
 * @brief Empty unit testing template
 * @cond
 * @brief Unit tests for the class
 */
class PolicyTest extends \PHPUnit_Framework_TestCase
{
    public function test1() {
        //$this->assertEquals($expected, $actual);
    }

    public function test_construct() {
        $row = array(
            'id' => 1,
            'PH_ID' => 1,
            'A_ID' => 1,
            'coverageStart' => '2016-02-17 00:00:00',
            'coverageStop' => '2016-02-17 00:00:00',
            'policyType' => 0
        );

        $policy = new Policy($row);
        $this->assertInstanceOf('Policy', $policy);
        $this->assertEquals(1, $policy->getId());
        $this->assertEquals(1, $policy->getPHID());
        $this->assertEquals(1, $policy->getAID());
        $this->assertEquals('2016-02-17 00:00:00', $policy->getCoverageStart());
        $this->assertEquals('2016-02-17 00:00:00', $policy->getCoverageStop());
        $this->assertEquals(0, $policy->getPolicyType());
    }

}

/// @endcond
?>s