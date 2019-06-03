<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_checkout
 *
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */


// No direct access to this file
defined('_JEXEC') or die('Restricted Access');

JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
JHtml::_('formbehavior.chosen', 'select');
JHtml::_('behavior.keepalive');
?>

<style>
.tab-title-format{
	padding-left: 10px;
	font-size: 20px;
}
</style>

<form action="<?php echo JRoute::_('index.php?option=com_checkout&view=orders&id=' . (int)$this->getFormValue('id')); ?>"
	method="post" name="adminForm" id="adminForm">
	<div class="form-horizontal">
		<h3><?php echo JText::_('COM_CHECKOUT_DETAILS_ID_LBL') . $this->getFormValue('id')?></h3>
		<p style="color: gray;"><?php echo JText::_('COM_CHECKOUT_DETAILS_ID_DESC') . $this->getFormValue('user_id')?></p>
		<?php echo JHtml::_('bootstrap.startTabSet', 'myTab', array('active' => 'general')); ?>
		<?php echo JHtml::_('bootstrap.addTab', 'myTab', 'general', JText::_('COM_CHECKOUT_TAB_DETAILS_TITLE', true)); ?>
		<div class="row-fluid">
			<div class="span6 form-horizontal">
				<span class="icon-user" style="font-size:20px;"></span>
				<span class="tab-title-format"><?php echo JText::_('COM_CHECKOUT_TAB_DETAILS_DETAIL_TITLE')?></span>
				<fieldset class="adminform">
					<?php foreach ($this->form->getFieldset('details') as $field): ?>
						<div class="control-group">
							<div class="control-label">
								<?php echo $field->label; ?>
							</div>
							<div class="controls">
								<?php echo $field->input; ?>
							</div>
						</div>
					<?php endforeach; ?>
				</fieldset>
			</div>
			<div class="span6 form-horizontal">
				<span class="icon-address" style="font-size:20px;"></span>
				<span class="tab-title-format"><?php echo JText::_('COM_CHECKOUT_TAB_DETAILS_DELIVERY_TITLE')?></span><br><br>
				<fieldset class="adminform">
					<?php foreach ($this->form->getFieldset('delivery') as $field): ?>
						<div class="control-group">
							<div class="control-label">
								<?php echo $field->label; ?>
							</div>
							<div class="controls">
								<?php echo $field->input; ?>
							</div>
						</div>
					<?php endforeach; ?>
				</fieldset>
			</div>
		</div>
		<?php echo JHtml::_('bootstrap.endTab'); ?>
		<?php echo JHtml::_('bootstrap.addTab', 'myTab', 'products', JText::_('COM_CHECKOUT_TAB_PRODUCTS_TITLE')); ?>
		<table class="table table-striped" id="productsList">
			<thead>
				<tr>
					<th width="10%">
						<?php echo JText::_('COM_CHECKOUT_TAB_PRODUCTS_SKU'); ?>
					</th>          
					<th width="6%">
						<?php echo JText::_('COM_CHECKOUT_TAB_PRODUCTS_IMG'); ?>
					</th>
					<th>
						<?php echo JText::_('COM_CHECKOUT_TAB_PRODUCTS_NAME'); ?>
					</th>       
					<th>
						<?php echo JText::_('COM_CHECKOUT_TAB_PRODUCTS_POINTS'); ?>
					</th>
					<th>
						<?php echo JText::_('COM_CHECKOUT_TAB_PRODUCTS_AMOUNT'); ?>
					</th>
					<th>
						<?php echo JText::_('COM_CHECKOUT_TAB_PRODUCTS_TOTAL'); ?>
					</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($this->items as $i => $item):?>      
					<tr class="row<?php echo $i % 2; ?>" sortable-group-id="1"> 
						<td>                
							<?php echo $item->sku; ?>
						</td>
						<td>
							<img src="<?php echo JRoute::_('../images/productos/'.$item->file_name); ?>">
						</td>                       
						<td>
							<?php echo $item->title; ?>
						</td>               
						<td>
							<?php echo number_format($item->price); ?>
						</td>
						<td>
							<?php echo number_format($item->quantity); ?>
						</td>    
						<td>
							<?php echo number_format($item->total); ?>
						</td>   
					</tr>
				<?php endforeach; ?>             
			</tbody>
		</table>
		<?php echo JHtml::_('bootstrap.endTab'); ?>
		<?php echo JHtml::_('bootstrap.endTabSet'); ?>
		<input type="hidden" name="task" value=""/>
		<?php echo JHtml::_('form.token'); ?>
	</div>
</form>