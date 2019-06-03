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

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers/html');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
JHtml::_('formbehavior.chosen', 'select');
JHtml::_('behavior.keepalive');

// Import CSS
$document = JFactory::getDocument();
$document->addStyleSheet(JUri::root() . 'media/com_cart/css/form.css');
?>
<script type="text/javascript">
	js = jQuery.noConflict();
	js(document).ready(function () {
		
	});

	Joomla.submitbutton = function (task) {
		if (task == 'cart.cancel') {
			Joomla.submitform(task, document.getElementById('cart-form'));
		}
		else {
			
			if (task != 'cart.cancel' && document.formvalidator.isValid(document.id('cart-form'))) {
				
				Joomla.submitform(task, document.getElementById('cart-form'));
			}
			else {
				alert('<?php echo $this->escape(JText::_('JGLOBAL_VALIDATION_FORM_FAILED')); ?>');
			}
		}
	}
</script>

<form
action="<?php echo JRoute::_('index.php?option=com_cart&layout=edit&id=' . (int) $this->item->id); ?>"
method="post" enctype="multipart/form-data" name="adminForm" id="cart-form" class="form-validate">
<div class="form-horizontal">
	<?php echo JHtml::_('bootstrap.startTabSet', 'myTab', array('active' => 'general')); ?>
	<?php echo JHtml::_('bootstrap.addTab', 'myTab', 'general', JText::_('COM_CART_TITLE_CART', true)); ?>
	<div class="row-fluid">
		<div class="span10 form-horizontal">
			<?php if (isset($this->item->id)) : ?>
				<?php $this->form->setFieldAttribute('product_id', 'readonly', 'true'); ?>
			<?php endif; ?>
			<fieldset class="adminform">
				<input type="hidden" name="jform[id]" value="<?php echo $this->item->id; ?>" />
				<?php echo $this->form->renderField('id'); ?>
				<?php echo $this->form->renderField('product_id'); ?>
				<?php echo $this->form->renderField('stock'); ?>
			</fieldset>
		</div>
	</div>
	<?php echo JHtml::_('bootstrap.endTab'); ?>
	<?php echo JHtml::_('bootstrap.endTabSet'); ?>
	<input type="hidden" name="task" value=""/>
	<?php echo JHtml::_('form.token'); ?>
</div>
</form>