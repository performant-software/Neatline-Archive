<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4 cc=76; */

/**
 * Tests for POST action in record API.
 *
 * @package     omeka
 * @subpackage  neatline
 * @copyright   2012 Rector and Board of Visitors, University of Virginia
 * @license     http://www.apache.org/licenses/LICENSE-2.0.html
 */

class Neatline_RecordControllerTest_Post
    extends Neatline_Test_AppTestCase
{


    /**
     * POST should create a new record and respond with the new id.
     */
    public function testPost()
    {

        $exhibit = $this->__exhibit();

        // New record data.
        $this->request->setMethod('POST')->setRawBody(
          Zend_Json::encode(array(
            'exhibit_id'        => $exhibit->id,
            'title'             => '1',
            'body'              => '2',
            'slug'              => '3',
            'tags'              => '4',
            'vector_color'      => '5',
            'stroke_color'      => '6',
            'select_color'      => '7',
            'vector_opacity'    => '8',
            'select_opacity'    => '9',
            'stroke_opacity'    => '10',
            'image_opacity'     => '11',
            'stroke_width'      => '12',
            'point_radius'      => '13',
            'point_image'       => '14',
            'min_zoom'          => '15',
            'max_zoom'          => '16',
            'map_focus'         => '17',
            'map_zoom'          => '18',
            'coverage'          => 'POINT(19 19)'
        )));

        // Hit /records with POST.
        $c1 = $this->_recordsTable->count();
        $this->dispatch('neatline/record');
        $c2 = $this->_recordsTable->count();
        $this->assertResponseCode(200);

        // Should create a record.
        $this->assertEquals($c2, $c1+1);

        // Should emit new id.
        $response = $this->getResponseArray();
        $this->assertNotNull($response->id);

        // Load the record.
        $record = $this->_recordsTable->find($response->id);

        // Should update fields.
        $this->assertEquals($record->exhibit_id,        $exhibit->id);
        $this->assertEquals($record->title,             '1');
        $this->assertEquals($record->body,              '2');
        $this->assertEquals($record->slug,              '3');
        $this->assertEquals($record->tags,              '4');
        $this->assertEquals($record->vector_color,      '5');
        $this->assertEquals($record->stroke_color,      '6');
        $this->assertEquals($record->select_color,      '7');
        $this->assertEquals($record->vector_opacity,    8);
        $this->assertEquals($record->select_opacity,    9);
        $this->assertEquals($record->stroke_opacity,    10);
        $this->assertEquals($record->image_opacity,     11);
        $this->assertEquals($record->stroke_width,      12);
        $this->assertEquals($record->point_radius,      13);
        $this->assertEquals($record->point_image,       '14');
        $this->assertEquals($record->min_zoom,          15);
        $this->assertEquals($record->max_zoom,          16);
        $this->assertEquals($record->map_focus,         '17');
        $this->assertEquals($record->map_zoom,          18);
        $this->assertEquals($record->coverage,          'POINT(19 19)');

    }


}