<?php
/** @file
 * @brief Empty unit testing template
 * @cond
 * @brief Unit tests for the class
 */
class PolicyHolderTest extends \PHPUnit_Framework_TestCase
{
    public function test1() {
        //$this->assertEquals($expected, $actual);
    }

    public function test_construct(){
        $row = array(
            'id' => 1,
            'firstName' => 'Nick',
            'lastName' => 'Reuter',
            'address' => '1400 Abbot #320',
            'city' => 'East Lansing',
            'state' => 'MI',
            'zipCode' => '48823',
            'notes' =>  'good person',
            'primPhoneNumber' => '5555555555',
            'secPhoneNumber' => '4444444444'
        );

        $policyHolder = new PolicyHolder($row);
        $this->assertInstanceOf('PolicyHolder', $policyHolder);
        $this->assertEquals(1, $policyHolder->getId());
        $this->assertEquals('Nick', $policyHolder->getFirstName());
        $this->assertEquals('Reuter', $policyHolder->getLastName());
        $this->assertEquals('1400 Abbot #320', $policyHolder->getAddress());
        $this->assertEquals('East Lansing', $policyHolder->getCity());
        $this->assertEquals('MI', $policyHolder->getState());
        $this->assertEquals('48823', $policyHolder->getZipCode());
        $this->assertEquals('good person', $policyHolder->getNotes());
        $this->assertEquals('5555555555', $policyHolder->getPrimPhoneNumber());
        $this->assertEquals('4444444444', $policyHolder->getSecPhoneNumber());
    }
}

/// @endcond
?>