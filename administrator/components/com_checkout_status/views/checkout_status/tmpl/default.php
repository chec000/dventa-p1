<?php
/**
 * @version    1.0.0
 * @package    COM_CHECKOUT_STATUS
 * @author     Zitdev <>
 * @copyright  Zitdev (C) 2017. All rights reserved.
 * @license    
 */

// No direct access
defined('_JEXEC') or die;

$user      = JFactory::getUser();
$canEdit    = $user->authorise('core.edit', 'com_checkout_status');
?>

<style>
.container-checkout-status{
	text-align: center;
	border: 1px solid #ddd;
	box-shadow: 0 0 5px #ddd;
	padding: 30px;
	background-color: white;
}

.container-checkout-status h1{
	padding-bottom: 20px;
	font-size: 45px;
}

.container-header{
	color: white;
	background-color: #1a3867;
	padding: 10px;
	margin: auto;
	width: 30%;
}

.btn-status-change{
	background-color: #e57373;
	padding: 6px 30px;
	font-weight: bold;
	font-size: 18px;
	color: black;
	text-transform: uppercase;
	box-shadow: 0 2px 5px 0 rgba(0,0,0,.26);
}

.btn-save{
	background-color: #26a69a;
	padding: 6px 30px;
	font-weight: bold;
	font-size: 18px;
	color: white;
	text-transform: uppercase;
	box-shadow: 0 2px 5px 0 rgba(0,0,0,.26);
}

.btn-status-change:hover{
	text-decoration: none;
	color: black;
}

.status-title{
	padding-bottom: 50px;
}

.p-open-date{
	font-weight: bold;
}

.p-close-date{
	font-weight: bold;
}

.l-open-date{
	font-weight: bold;
	font-size: 16px;
}

.l-close-date{
	font-weight: bold;
	font-size: 16px;
}

@media (max-width: 1000px) {
	.container-header{
		width: 100%;
	}

	.container-checkout-status{
		padding: 40px;
		padding-right: 50px;
	}
}
</style>
<div id="j-sidebar-container" class="span2">
	<?php echo $this->sidebar; ?>
</div>
<div id="j-main-container" class="span10">
	<div class="container-checkout-status">
		<form action="<?php echo JRoute::_('index.php?option=com_checkout_status&view=checkout_status'); ?>"
			method="post" name="adminForm" id="adminForm">
			<div class="container-header">
				<?php if($this->checkoutstate):?>
					<h1><?php echo JText::_('COM_CHECKOUT_STATUS_OPENED'); ?></h1>
				<?php else:?>
					<h1><?php echo JText::_('COM_CHECKOUT_STATUS_CLOSED'); ?></h1>
				<?php endif;?>
				<h2 class="status-title"><?php echo JText::_('COM_CHECKOUT_STATUS_STATUS_TITLE'); ?></h2>
				<?php if ($canEdit) : ?>
					<p>
						<?php if($this->checkoutstate):?>
							<a class="btn-status-change" href="<?php echo JRoute::_('index.php?option=com_checkout_status&task=closeCheckout');?>"><?php echo JText::_('COM_CHECKOUT_STATUS_CLOSE'); ?></a>
						<?php else:?>
							<a class="btn-status-change" href="<?php echo JRoute::_('index.php?option=com_checkout_status&task=openCheckout');?>"><?php echo JText::_('COM_CHECKOUT_STATUS_OPEN'); ?></a>
						<?php endif;?>
					</p>
				<?php endif; ?>
				<p class="p-open-date"><?php echo JText::_('COM_CHECKOUT_STATUS_OPEN_DATE'); ?>: <?php echo $this->startDate?></p>
				<p class="p-close-date"><?php echo JText::_('COM_CHECKOUT_STATUS_CLOSE_DATE'); ?>: <?php echo $this->endDate?></p>
			</div>
			<?php if ($canEdit) : ?>
				<div class="container-body">
					<h2><?php echo JText::_('COM_CHECKOUT_STATUS_STATUS_CHANGE'); ?></h2>
					<label class="l-open-date" for=""><?php echo JText::_('COM_CHECKOUT_STATUS_OPEN_DATE'); ?></label>
					<input type="date" name="startDate" min="<?php echo $this->startLimit; ?>">
					<label class="l-close-date" for=""><?php echo JText::_('COM_CHECKOUT_STATUS_CLOSE_DATE'); ?></label>
					<input type="date" name="endDate" min="<?php echo $this->endLimit; ?>">	
				</div>
				<button class="btn-save" type="submit"><?php echo JText::_('COM_CHECKOUT_STATUS_SAVE'); ?></button>
			<?php endif; ?>
		</form>
	</div>
</div>