<?php

defined('_JEXEC') or die('Restricted access');

JText::script('COM_CATALOG_PAGE_FIRST');
JText::script('COM_CATALOG_PAGE_PREVIOUS');
JText::script('COM_CATALOG_PAGE_NEXT');
JText::script('COM_CATALOG_PAGE_LAST');
?>

<style>
.icon-thumbs-up{
	font-size: 25px;
}

.icon-thumbs-up:hover{
	color: red;
}

.icon-thumbs-down{
	font-size: 25px;
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
			<div class="alert-message"><?php echo JText::_('COM_CATALOG_MAIN_LOGIN_MSG');?></div>
		</div>
	</div> 
<?php else:?>
	<div id="product_container">
		<div id="filter">
			<div id="filter-header"> 
				<span id="filter-header_result-count"><?php echo number_format($this->productsCount)?> <?php echo JText::_('COM_CATALOG_PRODUCT_COUNT');?></span> 
				<button id="filter-header_clear-btn" type="button" onclick="filter_clear()"><?php echo JText::_('COM_CATALOG_CLEAR_FILTERS');?></button>
			</div>
			<div id="filter-main"> 
				<div id="filter_category-filters"> 
					<h5><?php echo JText::_('COM_CATALOG_CATEGORIES');?></h5>
					<label id="category-filters__all"> 
						<input id="category-filters__all-input" type="checkbox" checked="checked" onchange="filter_all(this)">
						<span><?php echo JText::_('COM_CATALOG_ALL_CATEGORIES');?></span>
					</label>
					<?php foreach($this->categories['items'] as $category): ?>
						<div id="category-filters__categories">
							<label id="category-filters__category">
								<input id="category-filters__category-input" name="checkbox-item" type="checkbox"<?php echo $category['checked']?> value="<?php echo $category['id']?>" onchange="filter_one()">
								<span><?php echo $category['name']?></span>
								<span id="category-filters__count"><?php echo '('.$category['products'].')'?></span>
							</label>
						</div>
					<?php endforeach; ?>
					<?php if ($this->showPrice == 1): ?>
						<div id="filter_price-filter"> 
							<h5>
								<?php echo $this->currency?>
							</h5>
							<span class="filter_price"><?php echo JText::_('COM_CATALOG_MIN_PRICE');?>:   
								<span class="input-price" id="input_minPrice"><?php echo number_format($this->minPrice)?>
								</span>
								<input id="filter_price-min" type="range" min="<?php echo $this->minPriceRange?>" max="<?php echo $this->maxPriceRange?>" value="<?php echo $this->minPrice?>" step="1" onchange="filter_price()">
							</span>		
							<span class="filter_price"><?php echo JText::_('COM_CATALOG_MAX_PRICE');?>:
								<span class="input-price" id="input_maxPrice"><?php echo number_format($this->maxPrice)?>
								</span>
								<input id="filter_price-max" type="range" min="<?php echo $this->minPriceRange?>" max="<?php echo $this->maxPriceRange?>" value="<?php echo $this->maxPrice?>" step="1" onchange="filter_price()">
							</span>
						</div> 
					<?php endif ?>
				</div>
			</div>
			<div id="filter-footer">
				<button id="filter-btn" type="button" onclick="onFilter()"><?php echo JText::_('COM_CATALOG_FILTER');?></button>
			</div>
		</div>
		<div id="search">
			<div id="search-wrapper"> 
				<input id="product-picker__search-input" placeholder="<?php echo JText::_('COM_CATALOG_SEARCH');?>" type="search" onkeydown="filter_search(this)" value='<?php echo $this->params['search'];?>'>
				<?php echo JText::_('COM_CATALOG_PRODUCTS_PER_PAGE');?>
				<select id="page_selector" onchange="change_size(this.value)">  				
					<option></option>
					<?php foreach($this->pagesSize as $page): ?>
						<option 
						<?php 
						if (isset($this->params['page_size']) && $this->params['page_size'] == $page) 
							echo "selected";?>><?php echo $page;?>
					</option>
				<?php endforeach; ?>
			</select>
                        <?php if ($this->showPaginator ==='top'||$this->showPaginator ==='topandbottom'): ?>        
			<?php if ($this->pages['pages_count'] > 1 and $this->pages['current'] <= $this->pages['pages_count']): ?>
				<div class="product-pagination">
					<a class="active"><?php echo $this->pages['current']?> <?php echo JText::_('COM_CATALOG_PAGINATOR_OF');?> <?php echo $this->pages['pages_count']?></a>
					<a onclick="change_page(this)"><?php echo JText::_('COM_CATALOG_PAGE_FIRST');?></a>				
					<a onclick="change_page(this)"><?php echo JText::_('COM_CATALOG_PAGE_PREVIOUS');?></a>
					<?php foreach($this->numbers as $number): ?>
						<a onclick="change_page(this)"><?php echo $number?></a>		
					<?php endforeach; ?>
					<a style="display: none;" id="page-last" onclick="change_page(this)"><?php echo $this->pages['pages_count']?></a>

					<a onclick="change_page(this)"><?php echo JText::_('COM_CATALOG_PAGE_NEXT');?></a>				
					<a onclick="change_page(this)"><?php echo JText::_('COM_CATALOG_PAGE_LAST');?></a>
				</div> 
			<?php endif ?>
                        <?php endif ?>
		</div> 
	</div>
	<div id="products">
		<button type="button" id="products_sort-btn-title" onclick="titleOrder()"><?php echo JText::_('COM_CATALOG_ORDER_TITLE');?></button>
		<button type="button" id="products_sort-btn-price" onclick="priceOrder()"><?php echo $this->currency?></button>
		<div class="product_grid">
			<?php foreach($this->products as $product): ?>
				<div class="product_item <?php echo ProductHelper::getImageClass(); ?>">
                                        <?php if ($this->showBrand == 1): ?>
							<div>
								<?php echo JText::_('COM_CATALOG_BRAND');?>
								<?php echo $product->brand?>				
							</div>
					<?php endif ?>
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
						<?php endif ?>
						
						<?php $this->likeOption = $this->getLikes($product->id); ?>
						<?php if(ProductHelper::getComponentParams('com_catalog', 'likes') == 1):?>
							<?php if(!is_null($this->likeOption)):?>
								<span class="icon-thumbs-<?php echo $this->likeOption;?> answered"></span>
							<?php else:?>
								<span onclick="onLike(<?php echo $product->id?>, 'products')" class="icon-thumbs-up"></span>
								<span onclick="onDislike(<?php echo $product->id?>, 'products')" class="icon-thumbs-down"></span>
							<?php endif;?>
						<?php endif;?>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
                <?php if ($this->showPaginator ==='bottom'||$this->showPaginator ==='topandbottom'): ?>
                <?php if ($this->pages['pages_count'] > 1 and $this->pages['current'] <= $this->pages['pages_count']): ?>
				<div class="product-pagination">
					<a class="active"><?php echo $this->pages['current']?> <?php echo JText::_('COM_CATALOG_PAGINATOR_OF');?> <?php echo $this->pages['pages_count']?></a>
					<a onclick="change_page(this)"><?php echo JText::_('COM_CATALOG_PAGE_FIRST');?></a>				
					<a onclick="change_page(this)"><?php echo JText::_('COM_CATALOG_PAGE_PREVIOUS');?></a>
					<?php foreach($this->numbers as $number): ?>
						<a onclick="change_page(this)"><?php echo $number?></a>		
					<?php endforeach; ?>
					<a style="display: none;" id="page-last" onclick="change_page(this)"><?php echo $this->pages['pages_count']?></a>

					<a onclick="change_page(this)"><?php echo JText::_('COM_CATALOG_PAGE_NEXT');?></a>				
					<a onclick="change_page(this)"><?php echo JText::_('COM_CATALOG_PAGE_LAST');?></a>
				</div> 
                <?php endif ?>
                <?php endif ?>
	</div
        
</div>
<?php endif;?>