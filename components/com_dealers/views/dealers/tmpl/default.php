<?php
defined('_JEXEC') or die;
?>
<div id="cedis-report">
  <table class="table table-hover">
    <thead>
      <tr>
          <th><strong><?php echo JText::_('COM_DEALERS_CEDISID_LABEL');?></strong></th>
          <th><?php echo JText::_('COM_DEALERS_CEDISNAME_LABEL');?></th>
          <th><?php echo JText::_('COM_DEALERS_STREET_LABEL');?></th>
          <th><?php echo JText::_('COM_DEALERS_EXTNUM_LABEL');?></th>
          <th><?php echo JText::_('COM_DEALERS_INTNUM_LABEL');?></th>
          <th><?php echo JText::_('COM_DEALERS_LOCATION_LABEL');?></th>
          <th><?php echo JText::_('COM_DEALERS_REFERENCE_LABEL');?></th>
          <th><?php echo JText::_('COM_DEALERS_CITY_LABEL');?></th>
          <th><?php echo JText::_('COM_DEALERS_STATE_LABEL');?></th>
          <th><?php echo JText::_('COM_DEALERS_ZIPCODE_LABEL');?></th>
          <th><?php echo JText::_('COM_DEALERS_TELEPHONE_LABEL');?></th>
          <th><?php echo JText::_('COM_DEALERS_ACTIVE_LABEL');?></th>
      </tr>
    <thead>
    <tbody>
    <?php foreach ($this->items as $item) : ?>

      <tr>
          <td><?php echo $item->cedis_id; ?></td>
          <td><?php echo $item->names_cedis; ?></td>
          <td><?php echo $item->street; ?></td>
          <td><?php echo $item->ext_number; ?></td>
          <td><?php echo $item->int_number; ?></td>
          <td><?php echo $item->location; ?></td>
          <td><?php echo $item->reference; ?></td>
          <td><?php echo $item->city; ?></td>
          <td><?php echo $item->state; ?></td>
          <td><?php echo $item->zip_code; ?></td>
          <td><?php echo $item->telephone; ?></td>
          <td><?php echo $item->active; ?></td>
      </tr>
    <?php endforeach; ?>
    </tbody>
  </table>
</div>
