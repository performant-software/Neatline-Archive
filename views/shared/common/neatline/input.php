<?php

/* vim: set expandtab tabstop=2 shiftwidth=2 softtabstop=2 cc=80; */

/**
 * @package     omeka
 * @subpackage  neatline
 * @copyright   2012 Rector and Board of Visitors, University of Virginia
 * @license     http://www.apache.org/licenses/LICENSE-2.0.html
 */

?>

<div class="form-group">

  <label>

    <?php echo __($label); ?>

    <?php if (isset($useCurrent) && $useCurrent): ?>
      ( <a class="label-link" name="set-<?php echo $name; ?>">
        <?php echo __('Use Current'); ?>
        </a> )
    <?php endif; ?>

  </label>

  <input

    type="<?php echo isset($type) ? $type : 'text'; ?>"
    class="form-control <?php echo @$class; ?>"

    <?php if (isset($name)): ?>
      name="<?php echo $name; ?>"
    <?php endif; ?>

    <?php if (isset($placeholder)): ?>
      placeholder="<?php echo $placeholder; ?>"
    <?php endif; ?>

    <?php if (isset($bind)): ?>
      rv-value="<?php echo $bind; ?>"
    <?php endif; ?>

    <?php if (isset($value)): ?>
      value="<?php echo $value; ?>"
    <?php endif; ?>

  />

</div>
