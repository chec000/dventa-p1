<?php

defined('_JEXEC') or die('Restricted access');
?>

<?php if($this->order_id > 0 && WishlistHelper::getConfigParams('system.notifications') != 'none'):?>
	<?php if($this->notificationStatus):?>
		<div id="system-message-container">
			<div class="alert alert-success">
				<button type="button" class="close" data-dismiss="alert">×</button>
				<h4 class="alert-heading"><?php echo JText::_('COM_WISHLIST_MAIL_NTF_TITLE')?></h4>
				<div class="alert-message"><?php echo JText::_('COM_WISHLIST_MAIL_NTF_MSG')?></div>
			</div>
		</div>
	<?php else:?>
		<div id="system-message-container">
			<div class="alert alert-error">
				<button type="button" class="close" data-dismiss="alert">×</button>
				<h4 class="alert-heading"><?php echo JText::_('COM_WISHLIST_MAIL_NTF_TITLE_ERR');?></h4>
				<div class="alert-message"><?php echo JText::_('COM_WISHLIST_MAIL_NTF_MSG_ERR');?></div>
			</div>
		</div>
	<?php endif;?>
<?php endif;?>
<div class="container">
	<?php $userId = isset($this->userId)?$this->userId:null;?>
	<?php if($userId===0):?>
		<div id="system-message-container">
			<div class="alert alert-error">
				<button type="button" class="close" data-dismiss="alert">×</button>
				<h4 class="alert-heading"><?php echo JText::_('COM_WISHLIST_LOGIN_TITLE');?></h4>
				<div class="alert-message"><?php echo JText::_('COM_WISHLIST_LOGIN_MSG');?></div>
			</div>
		</div>
	<?php else:?>
		<?php if($this->order_id > 0):?>
			<div class="confirmation-header">
				<h2><?php echo JText::_('COM_WISHLIST_PRINT_TITLE');?></h2>
				<h3><?php echo JText::_('COM_WISHLIST_PRINT_MSG');?></h3>
			</div>
			<div class="confirmation-body">
				<h4><?php echo JText::_('COM_WISHLIST_PRINT_NUMBER');?></h4>
				<h3><?php echo $this->order_id?></h3>
				<a class="checkout-view__step-link"></a>
			</div>
			<div class="confirmation-footer">
				<p><?php echo JText::_('COM_WISHLIST_PRINT_NUMBER_MSG');?></p>
			</div>
			<!--div class="confirmation-image">
				<img src=<?php echo (JURI::Root(true) . '/images/confirmprint.jpg'); ?>>
			</div-->
			<div id="cart-view__actions">
				<a type="submit" id="cart-view__add-btn" href="index.php?option=com_wishlist"><?php echo JText::_('COM_WISHLIST_RETURN');?></a>
			</div>
		<?php else:?>
			<div id="system-message-container">
				<div class="alert alert-error">
					<button type="button" class="close" data-dismiss="alert">×</button>
					<h4 class="alert-heading"><?php echo JText::_('COM_WISHLIST_RELOAD_TITLE_ERR');?></h4>
					<div class="alert-message"><?php echo JText::_('COM_WISHLIST_RELOAD_MSG_ERR');?></div>
				</div>
			</div>
			<div id="cart-view__actions">
				<a type="submit" id="cart-view__add-btn" href="index.php?option=com_catalog"><?php echo JText::_('COM_WISHLIST_ADD_PRODUCTS');?></a>
			</div>
		<?php endif;?>
	<?php endif;?>
</div>