<?php
/**
 * @version    CVS: 1.0.0
 * @package    Com_Report
 * @author     Othon Parra Alcantar <othon.parra@adventa.mx>
 * @copyright  
 * @license    Licencia Pública General GNU versión 2 o posterior. Consulte LICENSE.txt
 */

// No direct access
defined('_JEXEC') or die;

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers/');
JHtml::_('bootstrap.tooltip');
JHtml::_('behavior.multiselect');
JHtml::_('formbehavior.chosen', 'select');

// Import CSS
$document = JFactory::getDocument();
$document->addStyleSheet(JUri::root() . 'administrator/components/com_report/assets/css/report.css');
$document->addStyleSheet(JUri::root() . 'media/com_report/css/list.css');

$user      = JFactory::getUser();
$userId    = $user->get('id');
$listOrder = $this->state->get('list.ordering');
$listDirn  = $this->state->get('list.direction');
$canOrder  = $user->authorise('core.edit.state', 'com_report');
$saveOrder = $listOrder == 'a.`ordering`';

	$saveOrderingUrl = 'index.php?option=com_report&task=userfields.saveOrderAjax&tmpl=component';
	JHtml::_('sortablelist.sortable', 'userfieldList', 'adminForm', strtolower($listDirn), $saveOrderingUrl);


$sortFields = $this->getSortFields();
?>

<form action="<?php echo JRoute::_('index.php?option=com_report&view=userfields'); ?>" method="post"
	  name="adminForm" id="adminForm">
	<?php if (!empty($this->sidebar)): ?>
	<div id="j-sidebar-container" class="span2">
		<?php echo $this->sidebar; ?>
	</div>
	<div id="j-main-container" class="span10">
		<?php else : ?>
		<div id="j-main-container">
			<?php endif; ?>

            <?php echo JLayoutHelper::render('joomla.searchtools.default', array('view' => $this)); ?>

			<div class="clearfix"></div>
			<table class="table table-striped" id="userfieldList">
				<thead>
				<tr>
					<?php if (isset($this->items[0]->ordering)): ?>
						<th width="1%" class="nowrap center hidden-phone">
							<span class="icon-menu-2"></span>
                        </th>
					<?php endif; ?>
					<th width="1%" class="hidden-phone" style="display: none;">
						<input type="checkbox" name="checkall-toggle" value=""
							   title="<?php echo JText::_('JGLOBAL_CHECK_ALL'); ?>" onclick="Joomla.checkAll(this)"/>
					</th>
					<?php if (isset($this->items[0]->state)): ?>
						<th width="1%" class="nowrap center">
								<?php echo JText::_('JSTATUS'); ?>
</th>
					<?php endif; ?>

									<th class='left'>
				<?php echo JText::_('COM_REPORT_USERFIELDS_ID'); ?>
				</th>
				<th class='left'>
				<?php echo JText::_('COM_REPORT_USERFIELDS_FIELD_NAME'); ?>
				</th>

					
				</tr>
				</thead>
				<tfoot>
				<tr>
					<td colspan="">
					</td>
				</tr>
				</tfoot>
				<tbody>
				<?php foreach ($this->items as $i => $item) :
					$ordering   = ($listOrder == 'a.ordering');
					$canCreate  = $user->authorise('core.create', 'com_report');
					$canEdit    = $user->authorise('core.edit', 'com_report');
					$canCheckin = $user->authorise('core.manage', 'com_report');
					$canChange  = $user->authorise('core.edit.state', 'com_report');
					?>
					<tr class="row<?php echo $i % 2; ?>">

						
							<td class="order nowrap center hidden-phone">
			
									<span class="sortable-handler hasTooltip"
										  title="">
							<i class="icon-menu"></i>
						</span>
									<input type="text" style="display:none" name="order[]" size="5"
										   value="<?php echo $item->ordering; ?>" class="width-20 text-area-order "/>
								
							</td>
						<td class="hidden-phone" style="display: none;">
							<?php echo JHtml::_('grid.id', $i, $item->id); ?>
						</td>
						<?php if (isset($this->items[0]->state)): ?>
							<td class="center">
								<?php echo JHtml::_('jgrid.published', $item->state, $i, 'userfields.', $canChange, 'cb'); ?>
</td>
						<?php endif; ?>

										<td>

					<?php echo $item->id; ?>
				</td>				
				<td>
					<?php echo $this->escape($item->field_name); ?>

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