<?php

defined('_JEXEC') or die('Restricted access');
?>
<?php $userId = isset($this->userId)?$this->userId:null;?>
<?php if($userId===0):?>
	<div id="system-message-container">
		<div class="alert alert-error">
			<button type="button" class="close" data-dismiss="alert">×</button>
			<h4 class="alert-heading"><?php echo JText::_('COM_CART_LOGIN_TITLE');?></h4>
			<div class="alert-message"><?php echo JText::_('COM_CART_LOGIN_MSG');?></div>
		</div>
	</div>  
<?php endif;?>
<h3 id="cart-view__title"><?php echo JText::_('COM_CART_NAME');?></h3>
<?php $items_count = count($this->items);?>
<?php if($items_count===0):?>
	<div id="cart-view__cart-empty"><?php echo JText::_('COM_CART_EMPTY_CART_MSG');?></div>
<?php else:?>
	<div id="cart-details">
		<button id="cart-view__empty-btn" onclick="emptyCart()"><?php echo JText::_('COM_CART_EMPTY_CART_BTN');?></button>
		<table id="cart-details__table"> 
			<thead> 
				<tr>
					<th colspan="2"><?php echo JText::_('COM_CART_FIELD_PRODUCT');?></th>
					<th>SKU</th>
					<?php if($this->showPrice == 1):?>
						<th><?php echo $this->currency?></th>
					<?php endif;?>
					<th><?php echo JText::_('COM_CART_FIELD_QUANTITY');?></th>
					<th colspan="2">Total</th>
				</tr>
			</thead>
			<tbody>
				<?php $i=0;?>
				<?php foreach($this->items as $item): ?>
					<tr>
						<td class="cart-details__image-cell">
							<a class="cart-details__image-link" href="index.php?option=com_catalog&task=product&id=<?php echo $item->id?>">
								<img id="cart-details__image" src=<?php echo (JURI::Root(true) . '/images/productos/'.$item->file_name); ?>>
							</a>
						</td>
						<td id="cart-details__title-cell"><?php echo $item->title?></td>
						<td id="cart-details__sku-cell"><?php echo $item->sku?></td>
						<input type="hidden" id="cart-details__price-cell_<?php echo $i?>" value="<?php echo $item->price?>">
						<?php if($this->showPrice == 1):?>
							<td id="cart-details__price-cell">
								<?php echo number_format($item->price)?>
							</td>
						<?php endif;?>
						<td id="cart-details__quantity-cell">
							<div id="product-view__select">
								<span id="quantity_input__btn-min"> 
									<button type="button" id="quantity-input__minus" name="<?php echo $i?>" onclick="cart_remove(this)">-</button> 
								</span> 
								<span id="quantity_input">
									<input id="quantity-input_<?php echo $i?>" class="quantity-input__input" min="1" max="999" type="number" value="<?php echo $item->quantity?>" readonly>
								</span> 
								<span id="quantity_input__btn-plus"> 
									<button type="button" id="quantity-input__plus" name="<?php echo $i?>" onclick="cart_add(this)">+</button> 
								</span>
							</div>
						</td>
						<input type="hidden" name="lineTotal" id="cart-details__lineTotal-cell-val_<?php echo $i?>" value="<?php echo $item->lineTotal?>">
						<?php if($this->showPrice == 1):?>
							<td class="cart-details__lineTotal-cell" id="cart-details__lineTotal-cell_<?php echo $i?>">
								<?php echo number_format($item->lineTotal)?>
							</td>
						<?php endif;?>
						<td class="cart-details__actions-cell">
							<button type="button" class="cart-details__delete-item-btn" id="delete-btn_<?php echo $i?>" value="<?php echo $item->id?>" onclick="deleteItem(this)">
							</button>
						</td>
					</tr>
					<?php $i++; ?>
				<?php endforeach; ?>
			</tbody>
			<tfoot>
				<?php if($this->showPrice == 1):?>
					<tr>
						<th colspan="5" id="cart-details__cart-total-title-cell" translate="">Total</th>
						<th id="cart-details__cart-total-cell"><?php echo number_format($this->lineTotals)?></th>
						<th></th>
					</tr>
				<?php endif;?>
			</tfoot>
		</table>
	</div>
<?php endif;?>
<div id="cart-view__actions">
	<a type="submit" id="cart-view__add-btn" href="index.php?option=com_catalog"><?php echo JText::_('COM_CART_ADD_PRODUCTS');?></a>
	<?php if($items_count > 0 && $this->checkoutStatus && $this->balance):?>
		<a type="button" id="cart-view__checkout-btn" href="index.php?option=com_checkout"><?php echo JText::_('COM_CART_CHECKOUT');?></a>
	<?php endif;?>
</div>