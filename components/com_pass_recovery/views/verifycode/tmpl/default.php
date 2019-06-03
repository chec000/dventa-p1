<?php
/**
 * @version    CVS: 1.0.0
 * @package    Com_Pass_recovery
 * @author     Adventa <othon.parra@adventa.mx>
 * @copyright  2017 Adventa
 * @license    Licencia Pública General GNU versión 2 o posterior. Consulte LICENSE.txt
 */
// No direct access
defined('_JEXEC') or die;
$app =JFactory::getApplication();
?>
<jdoc:include type="message" />
<form id="passrecover" action="" method="post" class="form-validate form-horizontal well">
	<fieldset>
		<p>Inserta el código que has recibido. Ten en cuenta que el código funciona solo por un tiempo.</p>
		<div class="control-group">
			<div class="control-label">
				<label id="jform_email-lbl" for="jform_email" class="hasPopover required" title="" data-content="" data-original-title="Code">
					Código
					<span class="star">&nbsp;*</span>
				</label>
			</div>
			<div class="controls">
				<input type="text" name="code" id="code" value="" class="validate-code required" size="30" required="required" aria-required="true">
			</div>
		</div>
	</fieldset>

<div class="control-group">
<div class="controls">
<button type="submit" class="button button-2 g-owlcarousel-item-button">Verificar código</button>
</div>
</div>
</form>
<?php 
require_once JPATH_COMPONENT . '/helpers/pass_recovery.php';
if (isset($_POST['code'])){
	if(strlen($_POST['code']) == 10){
		$valid_code = Pass_recoveryHelpersPass_recovery::getCode($_POST['code']);
		if($valid_code!=null){
			if($valid_code->state != 0){
				date_default_timezone_set("America/Monterrey");
				$current_date = (array) new DateTime();
				if($valid_code->time_limit > $current_date['date']){
					header("Location: ./index.php?option=com_pass_recovery&view=changepass&code=".$_POST['code']);
					die();				
				}else{
					
					$app->enqueueMessage('El código ha expirado.', 'Error');									
				}
			}else{
				$app->enqueueMessage('Este código ya ha sido usado.', 'Error');				
			}
		}else{
			$app->enqueueMessage('Inserte un código valido.', 'Error');
		}
	}else{
		$app->enqueueMessage('Inserte un código valido.', 'Error');
	}
	
}else{
	/* header("Location: ./index.php?option=com_pass_recovery&view=perfiles");
		die(); */
}
?>
