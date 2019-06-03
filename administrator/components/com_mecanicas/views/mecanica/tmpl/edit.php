<?php
defined('_JEXEC') or die;
?>

<!-- class="form-validate" enlaza y valida los campos obligatorios definidos en el form {forms/NombredelForm.xml} -->
<form action="<?php echo JRoute::_('index.php?option=com_mecanicas&layout=edit&id='.(int) $this->item->id); ?>" method="post" name="adminForm" id="adminForm" class="form-validate">
<!-- Aplica los estilos que se utilizan en el admin  {<div class="row-fluid"> <div class="span10 form-horizontal">} -->
<div class="row-fluid">
  <div class="span10 form-horizontal">
    <fieldset>
      <?php echo JHtml::_('bootstrap.startPane', 'myTab', array('active' => 'details')); ?>
      <?php echo JHtml::_('bootstrap.addPanel', 'myTab','details', empty($this->item->id) ? JText::_('COM_MECANICAS_NEW_MECANICA', true) : JText::sprintf('COM_MECANICAS_EDIT_MECANICA', $this->item->id, true)); ?>

      <?php foreach ($this->form->getFieldset('myfields') as $field): ?>
              <div class="control-group">
                <div class="control-label">
                  <?php echo $field->label; ?>
                </div>
                <div class="controls">
                  <?php echo $field->input; ?>
                </div>
              </div>
      <?php endforeach; ?>

<!--
      Si desearamos mostrar campo por campo, lo hacemos de la siguiente manera:

      <div class="control-group">
        <div class="control-label"><?php //echo $this->form->getLabel('title'); ?></div>
        <div class="controls"><?php //echo $this->form->getInput('title'); ?></div>
      </div>
-->

      <?php echo JHtml::_('bootstrap.endPanel'); ?>
      <input type="hidden" name="task" value="" />
      <?php echo JHtml::_('form.token'); ?>
      <?php echo JHtml::_('bootstrap.endPane'); ?>
    </fieldset>
  </div>
</div>
</form>
