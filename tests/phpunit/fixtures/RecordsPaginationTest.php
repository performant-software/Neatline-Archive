<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4 cc=76; */

/**
 * Fixture generator for "Records Pagination" Jasmine suite.
 *
 * @package     omeka
 * @subpackage  neatline
 * @copyright   2012 Rector and Board of Visitors, University of Virginia
 * @license     http://www.apache.org/licenses/LICENSE-2.0.html
 */

class FixturesTest_RecordsPagination extends Neatline_RecordsFixtureCase
{


    /**
     * `RecordsPagination.records.p12.json`
     * `RecordsPagination.records.p23.json`
     * `RecordsPagination.records.p34.json`
     * `RecordsPagination.records.p56.json`
     * `RecordsPagination.records.p6.json`
     */
    public function testRecordsPagination()
    {

        for ($i = 0; $i<6; $i++) {
            $record = new NeatlineRecord($this->exhibit);
            $record->added  = '200'.$i.'-01-01';
            $record->title  = 'Record'.$i;
            $record->save();
        }

        // Records 1-2.
        $this->request->setQuery(array('limit' => 2, 'offset' => 0));
        $this->writeFixtureFromRoute('neatline/records',
            'RecordsPagination.records.p12.json'
        );

        // Records 2-3.
        $this->resetResponse();
        $this->request->setQuery(array('limit' => 2, 'offset' => 1));
        $this->writeFixtureFromRoute('neatline/records',
            'RecordsPagination.records.p23.json'
        );

        // Records 3-4.
        $this->resetResponse();
        $this->request->setQuery(array('limit' => 2, 'offset' => 2));
        $this->writeFixtureFromRoute('neatline/records',
            'RecordsPagination.records.p34.json'
        );

        // Records 5-6.
        $this->resetResponse();
        $this->request->setQuery(array('limit' => 2, 'offset' => 4));
        $this->writeFixtureFromRoute('neatline/records',
            'RecordsPagination.records.p56.json'
        );

        // Record 6.
        $this->resetResponse();
        $this->request->setQuery(array('limit' => 2, 'offset' => 5));
        $this->writeFixtureFromRoute('neatline/records',
            'RecordsPagination.records.p6.json'
        );

    }


}