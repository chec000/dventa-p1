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

//Ejecutar cuando se use el código{
//Pass_recoveryHelpersPass_recovery::codeAccepted($_POST['code']);

require_once JPATH_COMPONENT . '/helpers/pass_recovery.php';

$valid_code = Pass_recoveryHelpersPass_recovery::getCode($_GET['code']);
date_default_timezone_set("America/Monterrey");
$date1 = $valid_code->time_limit;
$current_time = (array) new DateTime();
if (isset($_GET['code']) && strlen($_GET['code']) == 10 && $valid_code->state == 1 && $date1 > $current_time['date']){

?>
<jdoc:include type="message" />
<form id="passrecover" action="" method="post" class="form-validate form-horizontal well">
	<fieldset>
		<p>Ingresa una nueva contraseña para tu cuenta.</p>
		<div class="control-group">
			<div class="control-label">
				<label id="jform_email-lbl" for="jform_email" class="hasPopover required" title="" data-content="" data-original-title="Pass">
					Nueva contraseña
					<span class="star">&nbsp;*</span>
				</label>
			</div>
			<div class="controls">
				<input type="password" name="password" id="password" value="" class="validate-code required" size="30" required="required" aria-required="true">
			</div>	
		</div>

		<div class="control-group">
			<div class="control-label">
				<label id="jform_email-lbl" for="jform_email" class="hasPopover required" title="" data-content="" data-original-title="RPass">
					Repetir contraseña
					<span class="star">&nbsp;*</span>
				</label>
			</div>
			<div class="controls">
				<input type="password" name="rpassword" id="rpassword" value="" class="validate-code required" size="30" required="required" aria-required="true">
			</div>

			
		</div>

	</fieldset>

<div class="control-group">
<div class="controls">
<button type="submit" class="button button-2 g-owlcarousel-item-button">Cambiar contraseña</button>
</div>
</div>
</form>
<?php 
require_once JPATH_COMPONENT . '/helpers/pass_recovery.php';
	if (isset($_POST['password']) && isset($_POST['rpassword'])){
		if($_POST['password'] == $_POST['rpassword']){
			$result = Pass_recoveryHelpersPass_recovery::changePassword($_POST['password'], $valid_code->user);
			Pass_recoveryHelpersPass_recovery::codeAccepted($valid_code->code);
			header("Location: ./index.php?option=com_users&view=login");
			die(); 
		}else{
			$app->enqueueMessage('Las contraseñas deben coincidir.', 'Error');
		}
	}
}else{
		header("Location: ./index.php?option=com_pass_recovery&view=perfiles");
		die(); 
}
?>
