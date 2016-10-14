<?php
/** @file
 * @brief Empty unit testing template
 * @cond
 * @brief Unit tests for the class
 */
class BusinessClaimTest extends \PHPUnit_Framework_TestCase
{
    public function test1() {
        //$this->assertEquals($expected, $actual);
    }

    public function test_construct(){
        $row = array(
            'id' => 1,
            'P_ID' => 1,
            'Prop_ID' => 1,
            'D_ID' => 1,
            'contentDamage' => 1,
            'dwellingDamage' => 1,
            'floodInsurance' => 1,
            'floodInsurer' => 'Auto-Owners',
            'notes' => 'Tornado damaged main building'
        );

        $businessClaim = new BusinessClaim($row);
        $this->assertInstanceOf('BusinessClaim', $businessClaim);
        $this->assertEquals(1, $businessClaim->getId());
        $this->assertEquals(1, $businessClaim->getPID());
        $this->assertEquals(1, $businessClaim->getPropID());
        $this->assertEquals(1, $businessClaim->getDID());
        $this->assertEquals(1, $businessClaim->getContentDamage());
        $this->assertEquals(1, $businessClaim->getDwellingDamage());
        $this->assertEquals(1, $businessClaim->getFloodInsurance());
        $this->assertEquals('Auto-Owners', $businessClaim->getFloodInsurer());
        $this->assertEquals('Tornado damaged main building', $businessClaim->getNotes());
    }
}

/// @endcond
?>