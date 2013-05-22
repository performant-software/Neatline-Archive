<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4 cc=76; */

/**
 * @package     omeka
 * @subpackage  neatline
 * @copyright   2012 Rector and Board of Visitors, University of Virginia
 * @license     http://www.apache.org/licenses/LICENSE-2.0.html
 */

class AclTest_PublicExhibit extends Neatline_DefaultCase
{


    protected $_isAdminTest = false;


    public function setUp()
    {
        parent::setUp();
        $this->exhibit = $this->__exhibit('slug');
        $this->logout();
    }


    /**
     * Should be able to browse exhibits.
     */
    public function testCanBrowse()
    {
        $this->dispatch('neatline');
        $this->assertXpath('//a[@class="neatline"]');
    }


    /**
     * Should be able to view exhibits.
     */
    public function testCanShow()
    {
        $this->dispatch('neatline/show/slug');
        $this->assertXpath('//div[@id="neatline"]');
    }


    /**
     * Should be able to GET exhibits.
     */
    public function testCanGet()
    {
        $this->dispatch('neatline/exhibits/'.$this->exhibit->id);
        $this->assertNotEmpty($this->getResponseArray());
    }


    /**
     * Should not be able to PUT exhibits.
     */
    public function testCannotPut()
    {
        $this->writePut(array('title' => 'title'));
        $this->dispatch('neatline/exhibits/'.$this->exhibit->id);
        $this->assertNull($this->reload($this->exhibit)->title);
    }


}
