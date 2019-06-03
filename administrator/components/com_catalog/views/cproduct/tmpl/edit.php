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
            		var url = imageManager.fields.url.value; 
            		var filename = url.substring(url.lastIndexOf('/')+1);
            		setMedia(filename, id);
            	};
            });
        }
    }
    function setMedia(url, id){
    	jQuery('#'+id).val(url);
    }
</script>

<form action="<?php echo JRoute::_('index.php?option=com_catalog&layout=edit&id=' . (int) $this->item->id); ?>"
	method="post" name="adminForm" id="adminForm" class="form-validate">
	<div class="form-horizontal">
		<div class="row-fluid">
			<div class="span10 form-horizontal">
				<fieldset class="adminform">
					<?php foreach ($this->form->getFieldset('cproduct') as $field): ?>
						<div class="control-group">
							<div class="control-label">
								<?php echo $field->label; ?>
							</div>
							<div class="controls">
								<?php echo $field->input; ?>
							</div>
						</div>
					<?php endforeach; ?>
				</fieldset>
				<div class="control-group">
					<div class="control-label">
						<?php echo JText::_('PRODUCTS_IMAGE_LOAD'); ?>
					</div>
					<div class="controls">
						<a class="modal btn btn-micro" onclick="registerInsertAction('jform_file_name');" id="getImage" 
						href="index.php?option=com_media&view=images&tmpl=component&e_name=jform_file_name"  
						rel="{handler: 'iframe', size: {x: 950, y: 620}}"><span class="icon-upload"></span>
					</a>
				</div>
			</div> 
		</div>
	</div>

	<input type="hidden" name="option" value="com_catalog" />
	<input type="hidden" name="task" value=""/>
	<input type="hidden" name="boxchecked" value="0" />
	<?php echo JHtml::_('form.token'); ?>
</div>
</form>