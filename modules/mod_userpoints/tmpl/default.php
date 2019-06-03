<?php
/**
 * @copyright	Copyright (c) 2017 Adventa (http://www.adventa.com.mx/). All rights reserved.
 */
// no direct access
defined('_JEXEC') or die;

$document = JFactory::getDocument();
$document->addStyleSheet("modules/mod_userpoints/assets/css/style.css");
?>
<div class="wrap_userpoints">
  <div class="group_amount">
    <span class="<?php echo $params->get('coin_icon') ?>"></span>
     <?php echo $coin.' '.number_format($points,0) ?>
  </div>
  <div class="group_user" >
    <span class="<?php echo $params->get('user_icon') ?>"></span>
    <?php
      if((int)$params->get('user')==0){
        echo $user->name;
      }else{
        echo $user->username;
      }
    ?>
  </div>
</div>
