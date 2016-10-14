<?php
/** @file
 * @brief Empty unit testing template
 * @cond
 * @brief Unit tests for the class
 */
class PersonalClaimTest extends \PHPUnit_Framework_TestCase
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
            'otherDamage' => 1,
            'floodInsurance' => 1,
            'floodInsurer' => 'Auto-Owners',
            'notes' => 'Tornado damaged main building'
        );

        $personalClaim = new PersonalClaim($row);
        $this->assertInstanceOf('PersonalClaim', $personalClaim);
        $this->assertEquals(1, $personalClaim->getId());
        $this->assertEquals(1, $personalClaim->getPID());
        $this->assertEquals(1, $personalClaim->getPropID());
        $this->assertEquals(1, $personalClaim->getDID());
        $this->assertEquals(1, $personalClaim->getContentDamage());
        $this->assertEquals(1, $personalClaim->getDwellingDamage());
        $this->assertEquals(1, $personalClaim->getOtherDamage());
        $this->assertEquals(1, $personalClaim->getFloodInsurance());
        $this->assertEquals('Auto-Owners', $personalClaim->getFloodInsurer());
        $this->assertEquals('Tornado damaged main building', $personalClaim->getNotes());
    }
}

/// @endcond
?>