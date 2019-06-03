<?php

defined('_JEXEC') or die('Restricted access');
?>
<?php $userId = isset($this->userId)?$this->userId:null;?>
<?php if($userId===0):?>
	<div id="system-message-container">
		<div class="alert alert-error">
			<button type="button" class="close" data-dismiss="alert">×</button>
			<h4 class="alert-heading"><?php echo JText::_('COM_CHECKOUT_LOGIN_TITLE');?></h4>
			<div class="alert-message"><?php echo JText::_('COM_CHECKOUT_LOGIN_MSG');?></div>
		</div>
	</div>
	<?php else:?>
		<div class="container">
			<h1 class="checkout-confirmation__title"><?php echo JText::_('COM_CHECKOUT_CONFIRM_TITLE');?></h1>
			<p class="checkout-confirmation__help-text"><?php echo JText::_('COM_CHECKOUT_CONFIRM_MSG');?></p>
			<form action="<?php echo JRoute::_('index.php?option=com_checkout&task=checkoutPrint');?>"
				method="post" name="adminForm" id="adminForm">
				<div class="checkout-confirmation">
					<h2><?php echo JText::_('COM_CHECKOUT_DELIVERY_SUBTITLE');?></h2>
					<?php if($this->delivery_mode == 'user-address'):?>
						<div class="address-view">
							<div class="address-view__street">
								<label class="label-text"><?php echo JText::_('COM_CHECKOUT_FIELD_STREET');?></label>
								<label class="address-view__street-value"><?php echo $this->delivery_info['street']?></label>
								<input name="street" type="hidden" value="<?php echo $this->delivery_info['street']?>">
							</div>
							<div class="address-view__extNumber">
								<label class="label-text"><?php echo JText::_('COM_CHECKOUT_FIELD_EXTNUM');?></label>
								<label class="address-view__extNumber-value"><?php echo $this->delivery_info['extNum']?> </label>
								<input name="extNum" type="hidden" value="<?php echo $this->delivery_info['extNum']?>">
							</div>
							<div class="address-view__intNumber">
								<label class="label-text"><?php echo JText::_('COM_CHECKOUT_FIELD_INTNUM');?></label>
								<label class="address-view__intNumber-value"><?php echo $this->delivery_info['intNum']?> </label>
								<input name="intNum" type="hidden" value="<?php echo $this->delivery_info['intNum']?>">
							</div>
							<div class="address-view__reference">
								<label class="label-text"><?php echo JText::_('COM_CHECKOUT_FIELD_REFERENCE');?></label>
								<label class="address-view__reference-value"><?php echo $this->delivery_info['reference']?> </label>
								<input name="reference" type="hidden" value="<?php echo $this->delivery_info['reference']?>">
							</div>
							<div class="address-view__location">
								<label class="label-text"><?php echo JText::_('COM_CHECKOUT_FIELD_LOCATION');?></label>
								<label class="address-view__location-value"><?php echo $this->delivery_info['location']?> </label>
								<input name="location" type="hidden" value="<?php echo $this->delivery_info['location']?>">
							</div>
							<div class="address-view__zipCode">
								<label class="label-text"><?php echo JText::_('COM_CHECKOUT_FIELD_ZIPCODE');?></label>
								<label class="address-view__zipCode-value"><?php echo $this->delivery_info['zip_code']?> </label>
								<input name="zip_code" type="hidden" value="<?php echo $this->delivery_info['zip_code']?>">
							</div>
							<div class="address-view__city">
								<label class="label-text"><?php echo JText::_('COM_CHECKOUT_FIELD_CITY');?></label>
								<label class="address-view__city-value"><?php echo $this->delivery_info['city']?> </label>
								<input name="city" type="hidden" value="<?php echo $this->delivery_info['city']?>">
							</div>
							<div class="address-view__town">
								<label class="label-text"><?php echo JText::_('COM_CHECKOUT_FIELD_TOWN');?></label>
								<label class="address-view__town-value"><?php echo $this->delivery_info['town']?> </label>
								<input name="town" type="hidden" value="<?php echo $this->delivery_info['town']?>">
							</div>
							<div class="address-view__state">
								<label class="label-text"><?php echo JText::_('COM_CHECKOUT_FIELD_STATE');?></label>
								<label class="address-view__state-value"><?php echo $this->delivery_info['state']?> </label>
								<input name="state" type="hidden" value="<?php echo $this->delivery_info['state']?>">
							</div>
						</div>
						<?php else:?>
							<div class="cedis-view">
								<input type="hidden" name="cedisId" value="<?php echo $this->cedis->id ?>">
								<div class="cedis-view__cedisId">
									<label  class="label-text" translate=""><?php echo JText::_('COM_CHECKOUT_FIELD_CEDISID');?></label>
									<label class="cedis-view__cedisId-value"> <?php echo $this->delivery_info['id']?> </label>
								</div>
								<div class="cedis-view__name">
									<label  class="label-text" translate=""><?php echo JText::_('COM_CHECKOUT_FIELD_CEDIS');?></label>
									<label class="cedis-view__name-value"> <?php echo $this->delivery_info['cedis']?> </label>
								</div>
								<div class="cedis-view__city">
									<label  class="label-text" translate=""><?php echo JText::_('COM_CHECKOUT_FIELD_CITY');?></label>
									<label class="cedis-view__city-value"> <?php echo $this->delivery_info['city']?> </label>
								</div>
								<div class="cedis-view__state">
									<label  class="label-text" translate=""><?php echo JText::_('COM_CHECKOUT_FIELD_STATE');?></label>
									<label class="cedis-view__state-value"> <?php echo $this->delivery_info['estate']?> </label>
								</div>
							</div>
						<?php endif;?>
						<div id="cart-details">
							<h2><?php echo JText::_('COM_CHECKOUT_FIELD_PRODUCTS');?></h2>
							<table id="cart-details__table"> 
								<thead> 
									<tr>
										<th colspan="2"><?php echo JText::_('COM_CHECKOUT_FIELD_PRODUCT');?></th>
										<th><?php echo JText::_('COM_CHECKOUT_FIELD_SKU');?></th>
										<?php if($this->showPrice == 1):?>
											<th><?php echo $this->currency?></th>
										<?php endif;?>
										<th><?php echo JText::_('COM_CHECKOUT_FIELD_QUANTITY');?></th>
										<?php if($this->showPrice == 1):?>
											<th colspan="2"><?php echo JText::_('COM_CHECKOUT_FIELD_TOTAL');?></th>
										<?php endif;?>
									</tr>
								</thead>
								<tbody>
									<?php $i=0;?>
									<?php foreach($this->cartItems as $item): ?>
										<tr>
											<td class="cart-details__image-cell">
												<img id="cart-details__image" src=<?php echo (JURI::Root(true) . '/images/productos/'.$item->file_name); ?>>
												<?php if ($item->enabled == 0) {
													?>	
													<p style="color: red;"><?php echo JText::_('COM_CHECKOUT_PRODUCT_UNABLED'); ?></p>
													<?php
												} ?>
											</td>
											<td id="cart-details__title-cell"><?php echo $item->title?></td>
											<td id="cart-details__sku-cell"><?php echo $item->sku?></td>
											<?php if($this->showPrice == 1):?>
												<td id="cart-details__price-cell"><?php echo number_format($item->price)?>
											</td>
										<?php endif;?>
										<td id="cart-details__quantity-cell">
											<div id="product-view__select">
												<span id="quantity_input">
													<?php echo $item->quantity?>
												</span> 
											</div>
										</td>
										<input type="hidden" name="lineTotal" id="cart-details__lineTotal-cell-val_<?php echo $i?>" value="<?php echo $item->lineTotal?>">
										<?php if($this->showPrice == 1):?>
											<td class="cart-details__lineTotal-cell" id="cart-details__lineTotal-cell_<?php echo $i?>">
												<?php echo number_format($item->lineTotal)?>
											</td>
										<?php endif;?>
									</tr>
									<?php $i++; ?>
								<?php endforeach; ?>
							</tbody>
							<tfoot>
								<?php if($this->showPrice == 1):?>
									<tr>
										<th colspan="5" id="cart-details__cart-total-title-cell" translate=""><?php echo JText::_('COM_CHECKOUT_FIELD_TOTAL');?></th>
										<th id="cart-details__cart-total-cell"><?php echo number_format($this->lineTotals)?></th>
										<th></th>
									</tr>
								<?php endif;?>
							</tfoot>
						</table>
					</div>
				</div>
				<div class="submit">
					<input type="submit" class="next-btn" value="<?php echo JText::_('COM_CHECKOUT_FINISH');?>">
				</div>
			</form>
		</div>
		<?php endif;?>