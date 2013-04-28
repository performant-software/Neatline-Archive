<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4 cc=76; */

/**
 * @package     omeka
 * @subpackage  neatline
 * @copyright   2012 Rector and Board of Visitors, University of Virginia
 * @license     http://www.apache.org/licenses/LICENSE-2.0.html
 */

abstract class Neatline_ExpansionTable extends Omeka_Db_Table
{


    /**
     * Get an expansion row for a record.
     *
     * @param Neatline_ExpandableRow $parent The parent record.
     */
    public function findByParent($parent)
    {
        return $this->findBySql(
            'parent_id=?', array($parent->id), true
        );
    }


    /**
     * Delete an expansion row for a record.
     *
     * @param Neatline_ExpandableRow $parent The parent record.
     */
    public function deleteByParent($parent)
    {
        $expansion = $this->findByParent($parent);
        if ($expansion) $expansion->delete();
    }


    /**
     * Try to get an existing expansion row for a parent record. If one
     * doesn't exist, create a new one.
     *
     * @param Neatline_ExpandableRow $parent The parent record.
     * @return Neatline_ExpansionRow $parent The expansion.
     */
    public function getOrCreate($parent)
    {

        // Try to return an existing row.
        $expansion = $this->findByParent($parent);
        if ($expansion) return $expansion;

        else {

            // Otherwise, create one.
            $class = $this->_target;
            return new $class($parent);

        }

    }


}
