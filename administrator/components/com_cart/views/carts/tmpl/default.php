<?php
/**
 * @version    1.0.0
 * @package    COM_CART
 * @author     Zitdev <>
 * @copyright  Zitdev (C) 2017. All rights reserved.
 * @license    
 */

// No direct access
defined('_JEXEC') or die;

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers/');
JHtml::_('bootstrap.tooltip');
JHtml::_('behavior.multiselect');
JHtml::_('formbehavior.chosen', 'select');

$user      = JFactory::getUser();
$userId    = $user->get('id');
$listOrder = $this->state->get('list.ordering');
$listDirn  = $this->state->get('list.direction');
$canOrder  = $user->authorise('core.edit.state', 'com_cart');
$saveOrder = $listOrder == 'a.`ordering`';

if ($saveOrder)
{
	$saveOrderingUrl = 'index.php?option=com_cart&task=carts.saveOrderAjax&tmpl=component';
	JHtml::_('sortablelist.sortable', 'cartList', 'adminForm', strtolower($listDirn), $saveOrderingUrl);
}

$sortFields = $this->getSortFields();
?>

<form action="<?php echo JRoute::_('index.php?option=com_cart&view=carts'); ?>" method="post"
	name="adminForm" id="adminForm">
	<div id="j-main-container">
		<?php echo JLayoutHelper::render('joomla.searchtools.default', array('view' => $this)); ?>
		<div class="clearfix"></div>
		<table class="table table-striped" id="cartList">
			<thead>
				<tr>
					<?php if (isset($this->items[0]->ordering)): ?>
						<th width="1%" class="nowrap center hidden-phone">
							<?php echo JHtml::_('searchtools.sort', '', 'a.`ordering`', $listDirn, $listOrder, null, 'asc', 'JGRID_HEADING_ORDERING', 'icon-menu-2'); ?>
						</th>
					<?php endif; ?>
					<th width="1%" class="hidden-phone">
						<input type="checkbox" name="checkall-toggle" value=""
						title="<?php echo JText::_('JGLOBAL_CHECK_ALL'); ?>" onclick="Joomla.checkAll(this)"/>
					</th>
					<th class='left'>
						<?php echo JHtml::_('searchtools.sort',  'COM_CART_CONFIGS_ID', 'a.`id`', $listDirn, $listOrder); ?>
					</th>
					<th class='left'>
						<?php echo JHtml::_('searchtools.sort',  'COM_CART_CONFIGS_IDP', 'a.`product_id`', $listDirn, $listOrder); ?>
						<th class='left'>
							<?php echo JHtml::_('searchtools.sort',  'COM_CART_CONFIGS_KEY', 'p.`title`', $listDirn, $listOrder); ?>
						</th>
						<th class='left'>
							<?php echo JHtml::_('searchtools.sort',  'COM_CART_CONFIGS_VALUE', 'a.`stock`', $listDirn, $listOrder); ?>
						</th>
					</th>
				</tr>
			</thead>
			<tfoot>
				<tr>
					<td colspan="5">
						<?php echo $this->pagination->getListFooter(); ?>
					</td>
				</tr>
			</tfoot>
			<tbody>
				<?php foreach ($this->items as $i => $item) :
				$ordering   = ($listOrder == 'a.ordering');
				$canCreate  = $user->authorise('core.create', 'com_cart');
				$canEdit    = $user->authorise('core.edit', 'com_cart');
				$canCheckin = $user->authorise('core.manage', 'com_cart');
				$canChange  = $user->authorise('core.edit.state', 'com_cart');
				?>
				<tr class="row<?php echo $i % 2; ?>">
					<?php if (isset($this->items[0]->ordering)) : ?>
						<td class="order nowrap center hidden-phone">
							<?php if ($canChange) :
							$disableClassName = '';
							$disabledLabel    = '';

							if (!$saveOrder) :
								$disabledLabel    = JText::_('JORDERINGDISABLED');
								$disableClassName = 'inactive tip-top';
								endif; ?>
								<span class="sortable-handler hasTooltip <?php echo $disableClassName ?>"
									title="<?php echo $disabledLabel ?>">
									<i class="icon-menu"></i>
								</span>
								<input type="text" style="display:none" name="order[]" size="5"
								value="<?php echo $item->ordering; ?>" class="width-20 text-area-order "/>
							<?php else : ?>
								<span class="sortable-handler inactive">
									<i class="icon-menu"></i>
								</span>
							<?php endif; ?>
						</td>
					<?php endif; ?>
					<td class="hidden-phone">
						<?php echo JHtml::_('grid.id', $i, $item->id); ?>
					</td>
					<td>
						<?php echo $item->id; ?>
					</td>		
					<td>
						<?php echo $item->product_id; ?>
					</td>			
					<td>
						<?php if ($canEdit) : ?>
							<a href="<?php echo JRoute::_('index.php?option=com_cart&task=cart.edit&id='.(int) $item->id); ?>">
								<?php echo $this->escape($item->title); ?></a>
							<?php else : ?>
								<?php echo $this->escape($item->title); ?>
							<?php endif; ?>
						</td>	
						<td>
							<?php echo number_format($item->stock); ?>
						</td>		
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>

		<input type="hidden" name="task" value=""/>
		<input type="hidden" name="boxchecked" value="0"/>
		<input type="hidden" name="list[fullorder]" value="<?php echo $listOrder; ?> <?php echo $listDirn; ?>"/>
		<?php echo JHtml::_('form.token'); ?>
	</div>
</form>
<script>
	window.toggleField = function (id, task, field) {

		var f = document.adminForm, i = 0, cbx, cb = f[ id ];

		if (!cb) return false;

		while (true) {
			cbx = f[ 'cb' + i ];

			if (!cbx) break;

			cbx.checked = false;
			i++;
		}

		var inputField   = document.createElement('input');

		inputField.type  = 'hidden';
		inputField.name  = 'field';
		inputField.value = field;
		f.appendChild(inputField);

		cb.checked = true;
		f.boxchecked.value = 1;
		window.submitform(task);

		return false;
	};
</script>