<?php
defined('_JEXEC') or die('Restricted access');

JHtml::_('jquery.framework');
JHtml::_('script', 'jui/jquery.autocomplete.min.js', array('version' => 'auto', 'relative' => true));

$script = "
jQuery(function() {

	jQuery('.zc').autocomplete({
		serviceUrl: 'index.php/component/checkout/?task=autocompleteCode',
		paramName: 'search',
		minChars: 1,
		maxHeight: 400,
		width: 300,
		zIndex: 9999,
		deferRequestBy: 500,
		onSelect: function(index) {
			jQuery('.lc').val('');
			jQuery('#field-town').val('');
			jQuery('.city').val('');
			jQuery('#field-state').val('');
			jQuery('.lc').autocomplete('search', '');
		}
	});

	jQuery('.lc').focus(function(){
		jQuery('.lc').autocomplete({
			serviceUrl: 'index.php?option=com_checkout&task=autocompleteLocation&zc=' + jQuery('.zc').val(),
			paramName: 'search',
			minChars: 1,
			maxHeight: 400,
			width: 300,
			zIndex: 9999,
			deferRequestBy: 500,
			onSelect: function(index) {
				jQuery('.city').autocomplete({
					serviceUrl: 'index.php?option=com_checkout&task=autocompleteCity&zc=' + jQuery('.zc').val() + '&location=' + index.value,
					paramName: 'search',
					minChars: 1,
					maxHeight: 400,
					width: 300,
					zIndex: 9999,
					deferRequestBy: 500,
					onSelect: function(index) {
						jQuery('#field-town').autocomplete({
							serviceUrl: 'index.php?option=com_checkout&task=autocompleteCity&zc=' + jQuery('.zc').val() + '&location=' + jQuery('.lc').val() + '&city=' + index.value,
							paramName: 'search',
							minChars: 1,
							maxHeight: 400,
							width: 300,
							zIndex: 9999,
							deferRequestBy: 500
						}).val(index.data.town).data('autocomplete');
					},
				}).val(index.data.city).data('autocomplete');
				jQuery('#field-town').val(index.data.town);
				jQuery('#field-state').val(index.data.state);
			}
		});
		jQuery('.lc').val(' '); 
		jQuery('.lc').trigger('keyup'); 
	});

});
";

//JFactory::getDocument()->addScriptDeclaration($script);
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
		<h1 class="checkout-delivery__title"><?php echo JText::_('COM_CHECKOUT_DELIVERY_TITLE');?></h1>
		<?php if($this->delivery == 'user-address'):?>
			<form <?php if($this->editDelivery) echo 'action="'.JRoute::_('index.php?option=com_checkout&task=confirm').'"'; ?>
				method="post" name="adminForm" id="adminForm-user">
				<div class="field-street">
					<label class="label-text required"><?php echo JText::_('COM_CHECKOUT_FIELD_STREET');?></label>
					<input class="user-address-field" type="text" placeholder="<?php echo JText::_('COM_CHECKOUT_FIELD_STREET');?>" name="street" required value="<?php if (isset($this->address->street)) echo $this->address->street;?>" <?php if(!$this->editDelivery) echo "disabled"; ?>>
				</div>
				<div class="field-extNum">
					<label class="label-text required"><?php echo JText::_('COM_CHECKOUT_FIELD_EXTNUM');?></label>
					<input class="user-address-field" type="text" placeholder="<?php echo JText::_('COM_CHECKOUT_FIELD_EXTNUM');?>" name="extNum" required value="<?php if (isset($this->address->num_ext)) echo $this->address->num_ext;?>" <?php if(!$this->editDelivery) echo "disabled"; ?>>
				</div>
				<div class="field-intNum">
					<label class="label-text"><?php echo JText::_('COM_CHECKOUT_FIELD_INTNUM');?></label>
					<input class="user-address-field" type="text" placeholder="<?php echo JText::_('COM_CHECKOUT_FIELD_INTNUM');?>" name="intNum" value="<?php if (isset($this->address->num_int)) echo $this->address->num_int;?>" <?php if(!$this->editDelivery) echo "disabled"; ?>>
				</div>
				<div class="field-reference">
					<label class="label-text required"><?php echo JText::_('COM_CHECKOUT_FIELD_REFERENCE');?></label>
					<textarea <?php if(!$this->editDelivery) echo "disabled"; ?> class="user-address-field" placeholder="<?php echo JText::_('COM_CHECKOUT_FIELD_REFERENCE');?>" name="reference" required><?php if (isset($this->address->reference)) echo $this->address->reference;?></textarea>
				</div>
				<div class="field-zipCode">
					<label class="label-text required"><?php echo JText::_('COM_CHECKOUT_FIELD_ZIPCODE');?></label>
					<input class="user-address-field zc" onkeypress="return (event.charCode == 8 || event.charCode == 0) ? null : event.charCode >= 48 && event.charCode <= 57" type="text" placeholder="<?php echo JText::_('COM_CHECKOUT_FIELD_ZIPCODE');?>" name="zip_code" required maxlength="5" pattern="^\d+$" value="<?php if (isset($this->address->postal_code)) echo $this->address->postal_code;?>" <?php if(!$this->editDelivery) echo "disabled"; ?>>
				</div>
				<div class="field-location">
					<label class="label-text required"><?php echo JText::_('COM_CHECKOUT_FIELD_LOCATION');?></label>
					<input class="user-address-field lc" type="text" placeholder="<?php echo JText::_('COM_CHECKOUT_FIELD_LOCATION');?>" name="location" required value="<?php if (isset($this->address->neighborhood)) echo $this->address->neighborhood;?>" <?php if(!$this->editDelivery) echo "disabled"; ?>>
				</div>
				<div class="field-city">
					<label class="label-text"><?php echo JText::_('COM_CHECKOUT_FIELD_CITY');?></label>
					<input id="field-city" class="user-address-field city" type="text" placeholder="<?php echo JText::_('COM_CHECKOUT_FIELD_CITY');?>" name="city" readonly="true" value="<?php if (isset($this->address->city)) echo $this->address->city;?>" <?php if(!$this->editDelivery) echo "disabled"; ?>>
				</div>
				<div class="field-town">
					<label class="label-text required"><?php echo JText::_('COM_CHECKOUT_FIELD_TOWN');?></label>
					<input id="field-town" class="user-address-field" type="text" placeholder="<?php echo JText::_('COM_CHECKOUT_FIELD_TOWN');?>" name="town" readonly="true" value="<?php if (isset($this->address->town)) echo $this->address->town;?>" <?php if(!$this->editDelivery) echo "disabled"; ?>>
				</div>
				<div class="field-state">
					<label class="label-text required"><?php echo JText::_('COM_CHECKOUT_FIELD_STATE');?></label>
					<select id="field-state" class="user-address-field disabled" name="state" required <?php if(!$this->editDelivery) echo "disabled"; ?>>
						<option></option>
						<?php foreach($this->states as $item): ?>
							<option  <?php if (isset($this->address->estate) && ($this->address->estate == $item->state)) echo "selected";?> label="<?php echo $item->state?>" value="<?php echo $item->state?>">
								<?php echo $item->state?>
							</option>
						<?php endforeach; ?>
					</select>
				</div>
				<label class="user-address-edit">
					<input type="checkbox" onchange="editAddress()" <?php if(!$this->editDelivery) echo "disabled"; ?>>
					<span><?php echo JText::_('COM_CHECKOUT_FIELD_CHANGEADDRESS');?></span>
				</label>
			<?php else:?>
				<form action="<?php echo JRoute::_('index.php?option=com_checkout&task=confirm'); ?>"
					method="post" name="adminForm" id="adminForm-cedis">
					<input type="hidden" name="cedisId" value="<?php echo $this->cedis->id ?>"se>
					<div class="cedis-select">
						<label class="label-text required">
							<?php echo JText::_('COM_CHECKOUT_FIELD_DISTRIBUTION');?>
						</label>
						<select id="cedis-select" onchange="changeCedis(this.value)" required <?php if(!$this->editDelivery) echo "disabled"; ?>>
							<option value=""></option>
							<?php foreach($this->cedis_list as $item): ?>
								<option <?php if (isset($this->cedis->id) && $this->cedis->id == $item->id) echo "selected";?> label="<?php echo strtoupper($item->names_cedis)?>" value="<?php echo strtoupper($item->id)?>"><?php echo $item->names_cedis?></option>
							<?php endforeach; ?>
						</select>
					</div>	
					<div class="cedis-info">
						<div class="label-text-info">
							<label class="label-text"><?php echo JText::_('COM_CHECKOUT_FIELD_CEDISID');?></label>
							<label for=""><?php echo $this->cedis->cedis_id?></label>
						</div>
						<div class="label-text-info">
							<label class="label-text"><?php echo JText::_('COM_CHECKOUT_FIELD_CEDIS');?></label>
							<label for=""><?php echo $this->cedis->names_cedis?></label>
						</div>
						<div class="label-text-info">
							<label class="label-text"><?php echo JText::_('COM_CHECKOUT_FIELD_CITY');?></label>
							<label for=""><?php echo $this->cedis->city?></label>
						</div>
						<div class="label-text-info">
							<label class="label-text"><?php echo JText::_('COM_CHECKOUT_FIELD_STATE');?></label>
							<label for=""><?php echo $this->cedis->estate?></label>
						</div>
					</div>
				<?php endif;?>
				<?php if($this->delivery=='cedis' && $this->cedis->id > 0):?>
					<div class="submit">
						<input type="submit" class="next-btn" value="<?php echo JText::_('COM_CHECKOUT_CONTINUE');?>">
					</div>
				<?php endif;?>
				<?php if($this->delivery=='user-address'):?>
					<div class="submit">
						<input type="submit" class="next-btn" value="<?php echo JText::_('COM_CHECKOUT_CONTINUE');?>">
					</div>
				<?php endif;?>
			</form>
		</div>
	<?php endif;?>