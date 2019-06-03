<?php  
defined('_JEXEC') or die('Restricted access');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
JHtml::_('formbehavior.chosen', 'select');
JHtml::_('behavior.keepalive');
?>
<style>
.front-end-edit ul {
    padding: 0 !important;
}
.front-end-edit li {
    list-style: none;
    margin-bottom: 6px !important;
}
.front-end-edit label {
    margin-right: 10px;
    display: block;
    float: left;
    text-align: right;
    width: 100px !important;
}
.front-end-edit .radio label {
    float: none;
}
.front-end-edit .readonly {
    border: none !important;
    color: #666;
}    
.front-end-edit #editor-xtd-buttons {
    height: 50px;
    width: 600px;
    float: left;
}
.front-end-edit .toggle-editor {
    height: 50px;
    width: 120px;
    float: right;
}

#access-rules a:hover{
    background:#f5f5f5 url('../images/slider_minus.png') right  top no-repeat;
    color: #444;
}

fieldset.radio label{
    width: 50px !important;
}

form div.button-div{
    margin-left: 110px;
}    
</style>

<form action="<?php echo JRoute::_('index.php?option=com_catalog&layout=edit&id=' . (int) $this->item->id); ?>"
	method="post" name="adminForm" id="adminForm" class="form-validate">

	<div class="form-horizontal">
		<div class="row-fluid">
			<div class="span10 form-horizontal">
				<fieldset class="adminform">
                    <?php foreach ($this->form->getFieldset('cxrol') as $field): ?>
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
        </div>
    </div>

    <input type="hidden" name="option" value="com_catalog" />
    <input type="hidden" name="task" value=""/>
    <input type="hidden" name="boxchecked" value="0" />
    <?php echo JHtml::_('form.token'); ?>

</div>
</form>

