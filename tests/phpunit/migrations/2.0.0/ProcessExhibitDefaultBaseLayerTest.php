<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4 cc=76; */

/**
 * @package     omeka
 * @subpackage  neatline
 * @copyright   2012 Rector and Board of Visitors, University of Virginia
 * @license     http://www.apache.org/licenses/LICENSE-2.0.html
 */

class Migrate200Test_ProcessExhibitDefaultBaseLayer
    extends Neatline_Case_Migrate200
{


    /**
     * The old `default_base_layer` foreign key references should be moved
     * to the corresponding layer slugs in the new `spatial_layers` field.
     */
    public function setUp()
    {

        parent::setUp();
        $this->_loadFixture('ProcessExhibitDefaultBaseLayer.exhibits');

        $this->_upgrade();
        $this->_migrate();

    }


    public function testOpenStreetMap()
    {
        $this->assertEquals(
            $this->_getExhibitByTitle('OpenStreetMap')->spatial_layer,
            'OpenStreetMap'
        );
    }


    public function testGooglePhysical()
    {
        $this->assertEquals(
            $this->_getExhibitByTitle('GooglePhysical')->spatial_layer,
            'GooglePhysical'
        );
    }


    public function testGoogleStreets()
    {
        $this->assertEquals(
            $this->_getExhibitByTitle('GoogleStreets')->spatial_layer,
            'GoogleStreets'
        );
    }


    public function testGoogleHybrid()
    {
        $this->assertEquals(
            $this->_getExhibitByTitle('GoogleHybrid')->spatial_layer,
            'GoogleHybrid'
        );
    }


    public function testGoogleSatellite()
    {
        $this->assertEquals(
            $this->_getExhibitByTitle('GoogleSatellite')->spatial_layer,
            'GoogleSatellite'
        );
    }


    public function testStamenWatercolor()
    {
        $this->assertEquals(
            $this->_getExhibitByTitle('StamenWatercolor')->spatial_layer,
            'StamenWatercolor'
        );
    }


    public function testStamenToner()
    {
        $this->assertEquals(
            $this->_getExhibitByTitle('StamenToner')->spatial_layer,
            'StamenToner'
        );
    }


    public function testStamenTerrain()
    {
        $this->assertEquals(
            $this->_getExhibitByTitle('StamenTerrain')->spatial_layer,
            'StamenTerrain'
        );
    }


}