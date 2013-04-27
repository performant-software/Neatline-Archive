<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4 cc=76; */

/**
 * @package     omeka
 * @subpackage  neatline
 * @copyright   2012 Rector and Board of Visitors, University of Virginia
 * @license     http://www.apache.org/licenses/LICENSE-2.0.html
 */

abstract class Neatline_ExpandableRow extends Neatline_AbstractRow
{


    private $expansions = array();


    /**
     * Set an expansion field.
     *
     * @param string $name The field name.
     * @param mixed $value The value.
     */
    public function __set($name, $value)
    {
        $this->expansions[$name] = $value;
    }


    /**
     * Get an expansion field.
     *
     * @param string $name The field name.
     * @return mixed The value.
     */
    public function __get($name)
    {
        if (array_key_exists($name, $this->expansions)) {
            return $this->expansions[$name];
        }
    }


    /**
     * Merge expansion fields into public fields.
     *
     * @return array The record fields.
     */
    public function toArray()
    {
        return array_merge(parent::toArray(), $this->expansions);
    }


    /**
     * Remove `id` and `parent_id` fields.
     *
     * @return array The record fields.
     */
    public function toArrayForExpansion()
    {
        $fields = $this->toArray();
        unset($data['id'], $data['parent_id']);
        return $fields;
    }


    /**
     * Update expansions after saving.
     *
     * @param boolean $throwIfInvalid
     */
    public function save($throwIfInvalid = true)
    {

        parent::save($throwIfInvalid);

        // Gather expansion tables.
        $expansions = $this->getTable()->getExpansionTables();
        if (!$expansions) return;

        // Create or update expansions.
        foreach ($expansions as $expansion) {
            $row = $expansion->getOrCreate($this);
            $row->setArray($this->toArrayForExpansion());
            $row->save();

        }

    }

}