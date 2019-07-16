<?php
defined('_JEXEC') or die('Restricted access');

JHtml::_('jquery.framework');
JHtml::_('script', 'jui/jquery.autocomplete.min.js', array('version' => 'auto', 'relative' => true));

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
                <div class="street">
                    <label class="label-text required"><?php echo JText::_('COM_CHECKOUT_FIELD_STREET');?></label>
                    <input id="street" class="user-address-field" type="text" placeholder="<?php echo JText::_('COM_CHECKOUT_FIELD_STREET');?>" name="street" required value="<?php if (isset($this->address->street)) echo $this->address->street;?>" <?php if(!$this->editDelivery) echo "disabled"; ?>>
                </div>
                <div class="field-extNum">
                    <label class="label-text required"><?php echo JText::_('COM_CHECKOUT_FIELD_EXTNUM');?></label>
                    <input id="num_ext" class="user-address-field" type="text" placeholder="<?php echo JText::_('COM_CHECKOUT_FIELD_EXTNUM');?>" name="num_ext" required value="<?php if (isset($this->address->num_ext)) echo $this->address->num_ext;?>" <?php if(!$this->editDelivery) echo "disabled"; ?>>
                </div>
                <div class="field-intNum">
                    <label class="label-text"><?php echo JText::_('COM_CHECKOUT_FIELD_INTNUM');?></label>
                    <input class="user-address-field" type="text" placeholder="<?php echo JText::_('COM_CHECKOUT_FIELD_INTNUM');?>" name="num_int" id="num_int" value="<?php if (isset($this->address->num_int)) echo $this->address->num_int;?>" <?php if(!$this->editDelivery) echo "disabled"; ?>>
                </div>
                <div class="field-reference">
                    <label class="label-text required"><?php echo JText::_('COM_CHECKOUT_FIELD_REFERENCE');?></label>
                    <textarea <?php if(!$this->editDelivery) echo "disabled"; ?> class="user-address-field" placeholder="<?php echo JText::_('COM_CHECKOUT_FIELD_REFERENCE');?>" id="reference" name="reference" required><?php if (isset($this->address->reference)) echo $this->address->reference;?></textarea>
                </div>

                <!--!modificaciones-->
                <div class="field-calle">
                    <label class="label-text required"><?php echo JText::_('COM_CHECKOUT_FIELD_STREET1');?></label>
                    <input class="user-address-field" type="text" placeholder="<?php echo JText::_('COM_CHECKOUT_FIELD_STREET1');?>" name="between_street1" id="between_street1" value="<?php if (isset($this->address->street1)) echo $this->address->street1;?>" <?php if(!$this->editDelivery) echo "disabled"; ?>>
                </div>

                <div class="field-y-calle">
                    <label class="label-text required"><?php echo JText::_('COM_CHECKOUT_FIELD_STREET2');?></label>
                 <input class="user-address-field" type="text" placeholder="<?php echo JText::_('COM_CHECKOUT_FIELD_STREET2');?>" name="between_street2" id="between_street2" value="<?php if (isset($this->address->street2)) echo $this->address->street2;?>" <?php if(!$this->editDelivery) echo "disabled"; ?>>
                </div>

                <div class="field-calle">
                    <label class="label-text required"><?php echo JText::_('COM_CHECKOUT_FIELD_PHONE');?></label>
                    <input onkeypress="return (event.charCode == 8 || event.charCode == 0) ? null : event.charCode >= 48 && event.charCode <= 57" class="user-address-field" type="text" placeholder="<?php echo JText::_('COM_CHECKOUT_FIELD_PHONE');?>" name="phone" id="phone" value="<?php if (isset($this->address->phone)) echo $this->address->phone;?>" <?php if(!$this->editDelivery) echo "disabled"; ?>>
                </div>
                <div class="field-y-calle">
                    <label class="label-text required"><?php echo JText::_('COM_CHECKOUT_FIELD_CELLPHONE');?></label>
                 <input onkeypress="return (event.charCode == 8 || event.charCode == 0) ? null : event.charCode >= 48 && event.charCode <= 57" class="user-address-field" type="text" placeholder="<?php echo JText::_('COM_CHECKOUT_FIELD_CELLPHONE');?>" name="cellphone" id="cellphone" value="<?php if (isset($this->address->cellphone)) echo $this->address->cellphone;?>" <?php if(!$this->editDelivery) echo "disabled"; ?>>
                </div>
<!--!modificaciones-->
                
                <div class="field-zipCode">
                    <label class="label-text required"><?php echo JText::_('COM_CHECKOUT_FIELD_ZIPCODE');?></label>
                    <input  class="user-address-field zc" onkeypress="return (event.charCode == 8 || event.charCode == 0) ? null : event.charCode >= 48 && event.charCode <= 57" type="text" placeholder="<?php echo JText::_('COM_CHECKOUT_FIELD_ZIPCODE');?>" name="zip_code" id="zip_code" required maxlength="5" pattern="^\d+$" value="<?php if (isset($this->address->zip_code)) echo $this->address->zip_code;?>" <?php if(!$this->editDelivery) echo "disabled"; ?>>
                </div>
                <div class="field-location">
                    <label class="label-text required"><?php echo JText::_('COM_CHECKOUT_FIELD_LOCATION');?></label>
                    <input  class="user-address-field lc" type="text" placeholder="<?php echo JText::_('COM_CHECKOUT_FIELD_LOCATION');?>" name="location"
                    id="location" required value="<?php if (isset($this->address->location)) echo $this->address->location;?>" <?php if(!$this->editDelivery) echo "disabled"; ?>>
                </div>
                <div class="field-city">
                    <label class="label-text"><?php echo JText::_('COM_CHECKOUT_FIELD_CITY');?></label>
                    <input id="city" class="user-address-field city" type="text" placeholder="<?php echo JText::_('COM_CHECKOUT_FIELD_CITY');?>" name="city" readonly="true" value="<?php if (isset($this->address->city)) echo $this->address->city;?>" <?php if(!$this->editDelivery) echo "disabled"; ?>>
                </div>
                <div class="field-town">
                    <label class="label-text required"><?php echo JText::_('COM_CHECKOUT_FIELD_TOWN');?></label>
                    <input id="town" class="user-address-field" type="text" placeholder="<?php echo JText::_('COM_CHECKOUT_FIELD_TOWN');?>" name="town" readonly="true" value="<?php if (isset($this->address->town)) echo $this->address->town;?>" <?php if(!$this->editDelivery) echo "disabled"; ?>>
                </div>
                <div class="field-state">
                    <label class="label-text required"><?php echo JText::_('COM_CHECKOUT_FIELD_STATE');?></label>
                    <select id="state" class="user-address-field disabled" name="state" required <?php if(!$this->editDelivery) echo "disabled"; ?>>
                        <option></option>
                        <?php foreach($this->states as $item): ?>
                            <option  <?php if (isset($this->address->state) && ($this->address->state == $item->state)) echo "selected";?> label="<?php echo $item->state?>" value="<?php echo $item->state?>">
                                <?php echo $item->state?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <label class="user-address-edit">
                    <input type="checkbox" onchange="editAddress()" <?php if(!$this->editDelivery) echo "disabled"; ?>>
                    <span><?php echo JText::_('COM_CHECKOUT_FIELD_CHANGEADDRESS');?></span>
                </label>
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