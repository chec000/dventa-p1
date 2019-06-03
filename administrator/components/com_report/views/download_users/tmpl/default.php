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
$canOrder  = $user->authorise('core.edit.state', 'com_report');
?>

<h2>El reporte se generará con la siguiente estructura: </h2>
</p>
<h4>
	<?php
	//print_r($this->result[0]);
	$fields = $this->result;
	foreach($fields as $item){
		echo $item->field_name."</p>";
	}
	?>
</h4>


<form type="hidden"action="<?php echo JRoute::_('index.php?option=com_report&view=reportfields'); ?>" method="post"
	  name="adminForm" id="adminForm">
	
	<div id="j-main-container" class="span10">


			<div class="clearfix"></div>
			<table class="table table-striped" id="reportfieldList">
				<thead>
				<tr>
					<?php if (isset($this->items[0]->ordering)): ?>
						<th width="1%" class="nowrap center hidden-phone">
                        </th>
					<?php endif; ?>
					<th width="1%" class="hidden-phone" style="display: none;">
						<input type="checkbox" name="checkall-toggle" value=""
							   title="<?php echo JText::_('JGLOBAL_CHECK_ALL'); ?>" onclick="Joomla.checkAll(this)"/>
					</th>
					<?php if (isset($this->items[0]->state)): ?>
						<th width="1%" class="nowrap center">
</th>
					<?php endif; ?>

									<th class='left'>
				</th>
				<th class='left'>
				</th>

					
				</tr>
				</thead>
				<tfoot>
				<tr>
					<td colspan="<?php echo isset($this->items[0]) ? count(get_object_vars($this->items[0])) : 10; ?>">
					</td>
				</tr>
				</tfoot>
				<tbody>
				
				</tbody>
			</table>

			<input type="hidden" name="task" value=""/>
			<input type="hidden" name="boxchecked" value="0"/>
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