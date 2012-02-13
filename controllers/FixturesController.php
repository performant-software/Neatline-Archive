<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4; */

/**
 * Markup emitter for the Jasmine test suite.
 *
 * PHP version 5
 *
 * Licensed under the Apache License, Version 2.0 (the "License"); you may not
 * use this file except in compliance with the License. You may obtain a copy of
 * the License at http://www.apache.org/licenses/LICENSE-2.0 Unless required by
 * applicable law or agreed to in writing, software distributed under the
 * License is distributed on an "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS
 * OF ANY KIND, either express or implied. See the License for the specific
 * language governing permissions and limitations under the License.
 *
 * @package     omeka
 * @subpackage  neatline
 * @author      Scholars' Lab <>
 * @author      Bethany Nowviskie <bethany@virginia.edu>
 * @author      Adam Soroka <ajs6f@virginia.edu>
 * @author      David McClure <david.mcclure@virginia.edu>
 * @copyright   2011 The Board and Visitors of the University of Virginia
 * @license     http://www.apache.org/licenses/LICENSE-2.0.html Apache 2 License
 */

class Neatline_FixturesController extends Omeka_Controller_Action
{

    /**
     * Get table objects.
     *
     * @return void
     */
    public function init()
    {

        // Get tables.
        $this->_itemsTable =        $this->getTable('Item');
        $this->_filesTable =        $this->getTable('File');
        $this->_neatlinesTable =    $this->getTable('NeatlineExhibit');
        $this->_recordsTable =      $this->getTable('NeatlineDataRecord');
        $this->_mapsTable =         $this->getTable('NeatlineMapsMap');
        $this->_timelinesTable =    $this->getTable('NeatlineTimeTimeline');
        $this->_statusesTable =     $this->getTable('NeatlineRecordStatus');
        $this->_layersTable =       $this->getTable('NeatlineBaseLayer');

    }

    /**
     * Base exhibit markup.
     *
     * @return void
     */
    public function neatlinebaseAction()
    {

        // Supress the default Zend layout-sniffer functionality.
        $this->_helper->viewRenderer->setNoRender(true);

        // Get mock exhibit.
        $neatline = $this->_neatlinesTable->find(1);

        // Render.
        echo $this->view->partial('neatline/_neatline.php', array(
            'neatline' =>           $neatline,
            'public' =>             true,
            'dataSources' =>        array(),
        ));

    }

    /**
     * Editor environment markup.
     *
     * @return void
     */
    public function editorAction()
    {

        // Supress the default Zend layout-sniffer functionality.
        $this->_helper->viewRenderer->setNoRender(true);

        // Get records.
        $neatline =                 $this->_neatlinesTable->find(1);
        $map =                      $neatline->getMap();
        $image =                    $neatline->getImage();

        // Get Omeka taxonomies and layers.
        $collections =              $this->getTable('Collection')->findAll();
        $tags =                     $this->getTable('Tag')->findAll();
        $types =                    $this->getTable('ItemType')->findAll();
        $layers =                   $this->_layersTable->findAll();

        // Construct the data array for the exhibit.
        $neatlineData = array(
            'public' =>             false,
            'neatline' =>           $neatline,
            'dataSources' => array(
                'timeline' =>       neatline_getTimelineDataUrl($neatline->id),
                'map' =>            neatline_getMapDataUrl($neatline->id),
                'undated' =>        neatline_getUndatedItemsDataUrl($neatline->id)
            )
        );

        /**
         * ---------------
         * Render the partials.
         * ---------------
         */

        echo $this->view->partial('editor/_topbar.php', array(
            'neatline' => $neatline,
            'layers' => $layers
        ));

        echo $this->view->partial('editor/_item_browser.php', array(
            'tags' => $tags,
            'collections' => $collections,
            'types' => $types
        ));

        echo $this->view->partial('neatline/_neatline.php', $neatlineData);
        echo $this->view->partial('editor/_tooltips.php');

    }

    /**
     * Scroll arrows markup.
     *
     * @return void
     */
    public function scrollarrowsAction()
    {

        // Supress the default Zend layout-sniffer functionality.
        $this->_helper->viewRenderer->setNoRender(true);

        // Render.
        echo $this->view->partial('neatline/_arrows.php');

    }

    /**
     * Public items list markup.
     *
     * @return void
     */
    public function publicitemsAction()
    {

        // Supress the default Zend layout-sniffer functionality.
        $this->_helper->viewRenderer->setNoRender(true);

        // Get the exhibit and active records.
        $neatlineId = $this->_request->getParam('id');
        $neatline = $this->_neatlinesTable->find($neatlineId);;
        $records = $this->_recordsTable->getActiveRecordsByExhibit($neatline);

        // If no active records, pass empty array.
        if (!$records) $records = array();

        // Set the layout.
        echo $this->view->partial('data/public-items-ajax.php', array(
            'records' => $records,
            'neatline' => $neatline
        ));

    }

}
