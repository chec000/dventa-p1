<?php

defined('_JEXEC') or die('Restricted access');
?>

<style>
.icon-thumbs-up{
	font-size: 30px;
}

.icon-thumbs-up:hover{
	color: red;
}

.icon-thumbs-down{
	font-size: 30px;
}

.icon-thumbs-down:hover{
	color: red;
}

.answered{
	color: red;
}
</style>

<?php if($this->user===0):?>
	<div id="system-message-container">
		<div class="alert alert-error">
			<button type="button" class="close" data-dismiss="alert">×</button>
			<h4 class="alert-heading"><?php echo JText::_('COM_CATALOG_LOGIN_TITLE');?></h4>
			<div class="alert-message"><?php echo JText::_('COM_CATALOG_DETAILS_LOGIN_MSG');?></div>
		</div>
	</div> 
<?php else:?>
	<?php if(!empty($this->product)):?>
		<div id="product_detail_container">
			<div id="product-detail-header">
				<h3>
					<p style="margin: 0px;"><?php echo strtoupper($this->product->title)?></p>
					
					<small id="product-view__sku">SKU: <?php echo $this->product->sku?></small> 
					<input type="hidden" id="product-id" value="<?php echo $this->product->id?>">
				</h3> 
			</div>
			<div class="product-detail-img <?php echo ProductHelper::getImageClass(); ?>"> 
				<img src="<?php echo (JURI::Root(true) . '/images/productos/'.$this->product->file_name); ?>" id="product-view__image">
			</div>
			<div id="product-detail-main"> 
				<p id="product-view__description"><?php echo $this->product->description?></p>
                                        <?php if ($this->showBrand == 1): ?>
						<small style="font-size: 16px">
							<?php echo JText::_('COM_CATALOG_BRAND');?>
							<?php echo $this->product->brand?>				
						</small>
					<?php endif ?>
				<form id="product-view__add-form" name="addForm" submit="$ctrl.addProduct()"> 
                                        
					<?php if ($this->showPrice == 1): ?>
						<div id="product-view__price"><?php echo number_format($this->product->price)?>
							<div id="product-view__price-currency"><?php echo $this->currency?></div>
						</div>
					<?php endif ?>
					<?php if($this->stock > 0):?>
						<div id="product-stock"><?php echo number_format($this->stock)?><?php echo JText::_('COM_CATALOG_STOCK_LBL');?></div>
					<?php endif;?>
					<div id="product-view__select">
						<span id="quantity_input__btn-min"> 
							<button type="button" class="quantity-input__minus" onclick="cart_remove()">-</button> 
						</span> 
						<span><input class="quantity-input__input" min="1" max="999" id="product-view__quantity" name="quantity" type="number" value="1"></span> 
						<span id="quantity_input__btn-plus"> 
							<button type="button" class="quantity-input__plus" onclick="cart_add()">+</button> 
						</span>
					</div>
					<div id="product-view__actions">
						<?php if ($this->cartAdd == 1): ?>
							<button type="button" id="product-view__add-btn" onclick="addCart()"><?php echo JText::_('COM_CATALOG_CART_ADD');?></button>
						<?php else:?>
							<span><?php echo JText::_('COM_CATALOG_CART_DISABLED');?></span>
						<?php endif;?>

						<?php if(!$this->wishlistExist):?>
							<a href="<?php echo JRoute::_('index.php?option=com_wishlist&task=addList&product='.(int) $this->product->id); ?>"><button type="button" id="product-view__wishlist-btn"><?php echo JText::_('COM_CATALOG_WISHLIST_ADD');?></button></a>
						<?php endif;?>

						<button type="button" id="product-view__back-btn" onclick="history.back(-1)"><?php echo JText::_('COM_CATALOG_BACK_BTN');?></button> 
						<?php if(ProductHelper::getComponentParams('com_catalog', 'likes') == 1):?>
							<?php if(!is_null($this->likeOption)):?>
								<span class="icon-thumbs-<?php echo $this->likeOption;?> answered"></span>
							<?php else:?>
								<span onclick="onLike(<?php echo $this->product->id?>, 'product')" class="icon-thumbs-up"></span>
								<span onclick="onDislike(<?php echo $this->product->id?>, 'product')" class="icon-thumbs-down"></span>
							<?php endif;?>
						<?php endif;?>
						<p class="stock-message"><?php echo JText::_('COM_CATALOG_STOCK_MESSAGE');?></p>
					</div>
				</form> 
			</div>
		</div>
	<?php endif;?>
	<?php if(!empty($this->products_related)):?>
		<div id="product__related">
			<h2><?php echo JText::_('COM_CATALOG_RELATED_PRODUCTS');?></h2>
			<div id="product_grid-4">
				<?php foreach($this->products_related as $product): ?>
					<div class="product_item <?php echo ProductHelper::getImageClass(); ?>">
						<div class="product-grid__image">
							<a href="index.php?option=com_catalog&task=product&id=<?php echo $product->id?>">
								<img id="product-grid__image-link" src=<?php echo (JURI::Root(true) . '/images/productos/'.$product->file_name); ?>>
							</a>
						</div>
						<div id="product-grid__price">
							<a href="index.php?option=com_catalog&task=product&id=<?php echo $product->id?>">
								<?php echo $product->title?>
							</a>
							<?php if ($this->showPrice == 1): ?>
								<div id="product-grid__price_currency">
									<?php echo number_format($product->price)?>
									<?php echo $this->currency?>				
								</div>
							<?php endif;?>
							<?php if ($this->showBrand == 1): ?>
								<div>
									<?php echo JText::_('COM_CATALOG_BRAND');?>
									<?php echo $product->brand?>				
								</div>
							<?php endif ?>
							<?php $this->likeOption = $this->getLikes($product->id); ?>
							<?php if(ProductHelper::getComponentParams('com_catalog', 'likes') == 1):?>
								<?php if(!is_null($this->likeOption)):?>
									<span class="icon-thumbs-<?php echo $this->likeOption;?> answered"></span>
								<?php else:?>
									<span onclick="onLike(<?php echo $product->id?>, 'product')" class="icon-thumbs-up"></span>
									<span onclick="onDislike(<?php echo $product->id?>, 'product')" class="icon-thumbs-down"></span>
								<?php endif;?>
							<?php endif;?>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	<?php endif;?>
<?php endif;?>