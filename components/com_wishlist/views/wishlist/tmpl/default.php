<?php

defined('_JEXEC') or die('Restricted access');

JText::script('COM_WISHLIST_CHECKOUT_CONFIRM_MSG');
JText::script('COM_WISHLIST_DELETE_CONFIRM_MSG');
?>
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
	<h3 id="main-view__title"><?php echo JText::_('COM_WISHLIST_TITLE');?></h3>
	<h3 id="cart-view__title"><?php echo JText::_('COM_WISHLIST_NAME');?></h3>
	<?php $items_count = count($this->items);?>
	<?php if($items_count===0):?>
		<div id="cart-view__cart-empty"><?php echo JText::_('COM_WISHLIST_EMPTY_CART_MSG');?></div>
	<?php else:?>
		<label id="check_all-label">
			<input id="select_all-input" type="checkbox" onchange="check_all()">
			<?php echo JText::_('COM_WISHLIST_CHECK_ALL');?>
		</label>
		<div class="product_grid">
			<?php foreach($this->items as $product): ?>
				<div class="product_item">
					<div class="product-grid__image">
						<a href="index.php?option=com_catalog&task=product&id=<?php echo $product->id?>">
							<img id="product-grid__image-link" src=<?php echo (JURI::Root(true) . '/images/productos/'.$product->file_name); ?>>
						</a>
					</div>
					<div id="product-grid__price">
						<a href="index.php?option=com_catalog&task=product&id=<?php echo $product->id?>">
							<?php echo $product->title?>
						</a>
						<div id="product-grid__price_currency">
							<?php if($this->showPrice == 1):?>
								<?php echo number_format($product->price)?>
								<?php echo $this->currency?>	
							<?php endif;?>
							<input type="checkbox" class="checkbox-item_input" name="checkbox-item" value="<?php echo $product->id?>">			
						</div>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
	<?php endif;?>
	<div id="cart-view__actions">
		<?php if($items_count > 0 && $this->checkoutStatus):?>
			<button id="cart-view__checkout-btn" onclick="onCheckout()"><?php echo JText::_('COM_WISHLIST_CHECKOUT');?></button>
			<button id="cart-view__empty-btn" onclick="onDelete()"><?php echo JText::_('COM_WISHLIST_DELETE');?></button>
		<?php endif;?>
	</div>
<?php endif;?>