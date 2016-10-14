<?php
/** @file
 * @brief Empty unit testing template
 * @cond
 * @brief Unit tests for the class
 */
class PolicyFormTest extends \PHPUnit_Framework_TestCase
{
    public function test1() {
        //$this->assertEquals($expected, $actual);
    }

    public function test_construct() {
        $row = array(
            'name' => 'Form1',
            'P_ID' => 1
        );

        $policyForm = new PolicyForm($row);
        $this->assertInstanceOf('PolicyForm', $policyForm);
        $this->assertEquals('Form1', $policyForm->getName());
        $this->assertEquals(1, $policyForm->getPID());
    }
}

/// @endcond
?>