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
$app = JFactory::getApplication();

?>
<jdoc:include type="message" />
<form id="passrecover" action="" method="post" class="form-validate form-horizontal well">
	<fieldset>
		<p>Por favor ingresa el número de teléfono con el que te has registrado. Se te enviará un código con el cual podrás restablecer tu contraseña.</p>
		<div class="control-group">
			<div class="control-label">
				<label id="jform_email-lbl" for="jform_email" class="hasPopover required" title="" data-content="" data-original-title="Email Address">
					Teléfono
					<span class="star">&nbsp;*</span>
				</label>
			</div>
			<div class="controls">
				<input type="text" name="phone" id="phone" value="" class="validate-username required" size="30" required="required" aria-required="true">
			</div>
		</div>
	</fieldset>

<div class="control-group">
	<div class="controls">
		<button type="submit" class="button button-2 g-owlcarousel-item-button">Enviar código</button>
	</div>
</div>
</form>
<?php 
require_once JPATH_COMPONENT . '/helpers/pass_recovery.php';
if (isset($_POST['phone'])){
	//echo $_POST['phone'];
	$phone = Pass_recoveryHelpersPass_recovery::getValidPhone($_POST['phone']);
	if ($phone != null){
		$getCode=Pass_recoveryHelpersPass_recovery::setPhoneCode(str_replace('"','',$phone->profile_value), $phone->user_id);
		if($getCode != '500'){
			header("Location: ./index.php?option=com_pass_recovery&view=verifycode");
			die();
		}else{
			$app->enqueueMessage('Ya se ha enviado un codigo a este número. Intentelo de nuevo mas tarde.', 'Error');
		}
		
	}else{
		
		$app->enqueueMessage('Inserte un número valido', 'Error');
		
	}
	
}else{
	
}
?>
