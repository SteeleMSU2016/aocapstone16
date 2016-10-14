<?php
/** @file
 * @brief Empty unit testing template
 * @cond
 * @brief Unit tests for the class
 */
class PropFormTest extends \PHPUnit_Framework_TestCase
{
    public function test1() {
        //$this->assertEquals($expected, $actual);
    }

    public function test_construct() {
        $row = array(
            'name' => 'Form1',
            'Prop_ID' => 1
        );

        $propForm = new PropForm($row);
        $this->assertInstanceOf('PropForm', $propForm);
        $this->assertEquals('Form1', $propForm->getName());
        $this->assertEquals(1, $propForm->getPropID());
    }
}

/// @endcond
?>