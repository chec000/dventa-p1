<?php
defined('_JEXEC') or die;
JHtml::_('behavior.formvalidator');
?>
<div class="wrapPerfil">
    <div id="componnetContent">
        <form  action="<?php echo JRoute::_('index.php?option=com_perfil&task=perfiles.save'); ?>" method="post" name="perfilForm" id="perfilForm" class="form-validate form-horizontal well" enctype="multipart/form-data">
            <fieldset>
                <legend>
                    <?php echo JText::_('COM_PERFIL_REGISTRATION_PROFILE_LABEL'); ?>
                </legend>
                <?php
                foreach ($this->form->getFieldset('mainWrap') as $field):
                    ?>
                <?php  if($this->params!=false): ?>

                    <?php foreach ($this->params as $param=>$value):
                        ?>
                        <?php  if($field->fieldname==$param): ?>
                        <div class="control-group">
                            <div class="control-label">
                                <?php echo ($field->label); ?>
                            </div>
                            <div class="controls">
                                <?php if ($field->fieldname === 'password1') : ?>
                                    <?php // Disables autocomplete       ?>
                                    <input type="password" style="display:none">
                                <?php endif;
                                ?>
                                <?php
                                echo $field->input;
                                ?>
                            </div>
                        </div>
                    <?php endif;?>

                    <?php endforeach; ?>

                <?php else:;?>
                    <div class="control-group">
                        <div class="control-label">
                            <?php echo ($field->label); ?>
                        </div>
                        <div class="controls">
                            <?php if ($field->fieldname === 'password1') : ?>
                                <?php // Disables autocomplete       ?>
                                <input type="password" style="display:none">
                            <?php endif;
                            ?>
                            <?php
                            echo $field->input;
                            ?>
                        </div>
                    </div>

                <?php endif;?>
                <?php  if($field->fieldname=='TERM'&&$this->params!=false): ?>

                    <div class="control-group">
                        <div class="control-label">
                            <?php echo ($field->label); ?>
                        </div>
                        <div class="controls">
                            <?php
                            echo ($field->input);
                            ?>
                        </div>
                    </div>
                <?php  endif; ?>


                <?php endforeach; ?>
            </fieldset>
            <div id="searchresults">

            </div>
            <div class="main-submit">
                <button type="submit" id="guardar" class="btn btn-primary validate">
                    <?php echo JText::_('JSUBMIT'); ?>
                </button>
            </div>
            <input type="hidden" name="option" value="com_perfil" />
            <input type="hidden" name="task" value="perfil.save" />
            <?php echo JHtml::_('form.token', array('id'=>'token')); ?>
        </form>
        <div id="componnetContent">
        </div>
