<?php
/** @file
 * @brief Empty unit testing template
 * @cond
 * @brief Unit tests for the class
 */
class DisasterDatasetTest extends \PHPUnit_Framework_TestCase
{
    public function test1() {
        //$this->assertEquals($expected, $actual);
    }

    public function test_construct() {
        $row = array(
            'D_ID' => 1,
            'P_ID' => 1
        );

        $disasterDataset = new DisasterDataset($row);
        $this->assertInstanceOf('DisasterDataset', $disasterDataset);
        $this->assertEquals(1, $disasterDataset->getDID());
        $this->assertEquals(1, $disasterDataset->getPID());
    }
}

/// @endcond
?>