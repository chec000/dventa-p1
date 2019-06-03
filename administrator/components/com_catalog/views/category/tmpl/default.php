<?php

defined('_JEXEC') or die('Restricted access');
JHTML::_('behavior.modal');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
JHtml::_('formbehavior.chosen', 'select');
JHtml::_('behavior.keepalive');
?>

<script>
  function registerInsertAction(id)
  {
    if (!jQuery("#sbox-window").is(':visible')) {
            setTimeout(function(){registerInsertAction(id);}, 200); //wait
            return;
          }

          var f = jQuery('#sbox-window iframe');
          
          if(f[0] == undefined){
            setTimeout(function(){registerInsertAction(id);}, 200); //wait
            return;
          } else {
            f.load(function(){//wait
              var imageManager = f[0].contentWindow.ImageManager;
              imageManager.onok = function()
              {
                setMedia(imageManager.fields.url.value, id);
              };
            });
          }
        }
        function setMedia(url, id){
          jQuery('#'+id).val(url);
        }
      </script>

<!--div id="j-sidebar-container" class="span2">
    <?php echo $this->sidebar; ?>
  </div-->
  <div id="j-main-container" class="span10">
    <?php if($this->update_status===0):?>
      <div id="system-message-container">
        <div class="alert alert-error">
          <button type="button" class="close" data-dismiss="alert">×</button>
          <h4 class="alert-heading"><?php echo JText::_('VIEW_CATEGORY_DEFAULT_ALERT_ERROR_HEADING')?></h4>
          <div class="alert-message"><?php echo JText::_('VIEW_CATEGORY_DEFAULT_ALERT_ERROR_MESSAGE')?></div>
        </div>
      </div>
    <?php elseif (is_null($this->update_status)): ?>
    <?php else:?>
      <div id="system-message-container">
        <div class="alert alert-success">
          <button type="button" class="close" data-dismiss="alert">×</button>
          <h4 class="alert-heading"><?php echo JText::_('VIEW_CATEGORY_DEFAULT_ALERT_SUCCESS_HEADING')?></h4>
          <div class="alert-message"><?php echo JText::_('VIEW_CATEGORY_DEFAULT_ALERT_SUCCESS_MESSAGE')?></div>
        </div>
      </div>
    <?php endif;?>
    <form action="<?php echo JRoute::_('index.php?option=com_catalog&view=category&id='. (int)$this->category->id); ?>"
      method="post" name="adminForm" id="adminForm">
      <div class="row-fluid">
        <div class="span10 form-horizontal">
          <fieldset>
            <div class="control-group">
              <div class="control-label">
               <?php echo JText::_('VIEW_CATEGORIES_DEFAULT_TABLE_ID'); ?>
             </div>
             <div class="controls">
               <?php echo $this->category->id?>
             </div>
           </div>    

           <div class="control-group">
            <div class="control-label">
              <?php echo JText::_('VIEW_CATEGORIES_DEFAULT_TABLE_NAME'); ?>
            </div>
            <div class="controls">
             <?php echo $this->category->name?>
           </div>
         </div> 

         <div class="control-group">
          <div class="control-label">
            <?php echo JText::_('VIEW_CATEGORIES_DEFAULT_TABLE_DESC'); ?>
          </div>
          <div class="controls">
           <?php echo $this->category->description?>
         </div>
       </div>    
       
       <div class="control-group">
        <div class="control-label">
         <?php echo JText::_('VIEW_CATEGORIES_DEFAULT_TABLE_IMAGEURL'); ?>
       </div>
       <div class="controls">
        <a class="modal btn btn-micro" onclick="registerInsertAction('imgurl');" id="getImage" 
        href="index.php?option=com_media&view=images&tmpl=component&e_name=imgurl"  
        rel="{handler: 'iframe', size: {x: 950, y: 620}}"><span class="icon-upload"></span>
      </a>
      <input class="field-user-input-name" id="imgurl" value="<?php echo JURI::Root(false).'/'.$this->category->file_name?>" placeholder="Ruta de la imagen" type="text" name="fileName">
    </div>
  </div>   
  
  <div class="control-group">
    <div class="control-label">
     <?php echo JText::_('VIEW_CATEGORIES_DEFAULT_TABLE_IMAGE'); ?>
   </div>
   <div class="controls">
     <img style="max-width: 20%;" src="<?php echo JURI::Root(false).'/'.$this->category->file_name?>" class="image-preview" alt="Preview">
   </div>
 </div>    
 
 <div class="control-group">
  <div class="control-label">
   <?php echo JText::_('VIEW_CATEGORIES_DEFAULT_TABLE_PRODUCTS'); ?>
 </div>
 <div class="controls">
   <?php echo $this->category->products?>
 </div>
</div>     
<input type="hidden" name="task" value="category" />
<?php echo JHtml::_('form.token'); ?>    
</fieldset>
</div>
</div>  
</form>
</div>