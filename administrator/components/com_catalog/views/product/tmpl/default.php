<?php  
    defined('_JEXEC') or die('Restricted access'); 
?>
<script>
//window.location.reload();
    setTimeout(function(){
       window.location=window.location
    }, 59000);
</script>
<form action="<?php echo JRoute::_('index.php?option=com_catalog&view=product&layout=edit'); ?>"
method="post" name="adminForm" id="adminForm" class="form-horizontal">
    <div class="alert alert-info j-jed-message"
    style="margin-bottom: 40px; line-height: 2em; color:#333333;">
        <p><?php echo JText::_('COM_CATALOG_SYNC_DESC_TITLE'); ?><br>
        <?php echo JText::_('COM_CATALOG_SYNC_DESC_BODY'); ?><br>
        <h4><?php echo JText::_('COM_CATALOG_SYNC_DESC_FOOTER'); ?></h4></p>
    <input type="hidden" name="sync" value="1"/>
        <button class="btn" type="submit"<?php echo $this->isSync?' disabled="disabled"':''?>>
            <?php if($this->isSync):?>
            <img src="<?php echo JRoute::_('../media/system/images/modal/spinner.gif'); ?>" alt="" />
            <?php echo JText::_('COM_CATALOG_SYNC_MSG'); ?>          
            <?php else:?>
            <?php echo JText::_('COM_CATALOG_SYNC_BTN'); ?>
            <?php endif;?>
        </button>
    <a href="<?php echo $this->isSync?'':JRoute::_('index.php?option=com_catalog&view=products')?>" class="btn"<?php echo $this->isSync?'style="display: none"':''?>><?php echo JText::_('COM_CATALOG_SYNC_CLOSE'); ?></a>
    </div>
</form>