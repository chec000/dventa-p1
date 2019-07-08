<?php
defined('_JEXEC') or die;
JHtml::_('behavior.formvalidator');
?>
<div class="wrapPerfil">
    <div id="componnetContent" style="display:  <?php echo  ($this->params==true)?'block':'none'; ?>">
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
                                <?php
                                echo $field->input;
                                ?>
                            </div>
                        </div>

                        <?php  if($field->fieldname==$param&&$field->fieldname=="password"): ?>
                            <div class="control-group">
                                <div class="control-label">
                                    <label id="jform_password2-lbl" for="password2" class="hasPopover" title="" data-content="Registrar contraseña minimo 8 caracteres" data-original-title="Confirmar contraseña">
                                       Confirmar contraseña</label>
                                </div>
                                <div class="controls">
                                    <input id="password2" type="password" name="password2">
                                </div>
                            </div>


                        <?php endif;?>
                        <?php endif;?>

                    <?php endforeach; ?>

                <?php endif;?>
                <?php  if($field->fieldname=='TERM'&&$this->params!=false): ?>

                    <div class="control-group">


                        <div class="control-label">
                            <?php //echo ($field->label); ?>
                        </div>
                        <div class="controls">

                            <?php
                            echo ($field->input);
                            ?>
                            Acepto    
                            <a style="color:black;text-decoration: underline;" href="#" data-toggle="modal" data-target="#tc_modal">   <?php echo JText::_('COM_USERS_TERM_COND'); ?> </a>
                            |<a style="color:black;text-decoration: underline;" href="#" data-toggle="modal" data-target="#ap_modal">     <?php echo JText::_('COM_USERS_TERM_CONDITIONS'); ?></a>

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
