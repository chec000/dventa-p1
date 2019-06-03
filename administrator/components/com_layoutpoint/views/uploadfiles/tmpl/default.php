<?php
/**
 * @version    CVS: 1.0.0
 * @package    Com_Layoutpoint
 * @author     EDGAR <edgarmaster89@hotmail.com>
 * @copyright  2017 EDGAR
 * @license    Licencia Pública General GNU versión 2 o posterior. Consulte LICENSE.txt
 */

// No direct access
defined('_JEXEC') or die;

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers/');
JHtml::_('bootstrap.tooltip');
JHtml::_('behavior.multiselect');
JHtml::_('formbehavior.chosen', 'select');

// Import CSS
$document = JFactory::getDocument();
$document->addStyleSheet(JUri::root() . 'administrator/components/com_layoutpoint/assets/css/layoutpoint.css');
$document->addStyleSheet(JUri::root() . 'media/com_layoutpoint/css/list.css');
$document->addScript(JUri::root() . 'administrator/components/com_layoutpoint/assets/js/fileUpload.js');


$user      = JFactory::getUser();
$userId    = $user->get('id');
$listOrder = $this->state->get('list.ordering');
$listDirn  = $this->state->get('list.direction');
$canOrder  = $user->authorise('core.edit.state', 'com_layoutpoint');
$saveOrder = $listOrder == 'a.`ordering`';

if ($saveOrder)
{
	$saveOrderingUrl = 'index.php?option=com_layoutpoint&task=uploadfiles.saveOrderAjax&tmpl=component';
	JHtml::_('sortablelist.sortable', 'uploadfilesList', 'adminForm', strtolower($listDirn), $saveOrderingUrl);
}

$sortFields = $this->getSortFields();
?>

<form action="" method="post"
	  name="adminForm" id="adminForm">
	<?php if (!empty($this->sidebar)): ?>
	<div id="j-sidebar-container" class="span2">
		<?php echo $this->sidebar; ?>
	</div>
	<div id="j-main-container" class="span10">
		<?php else : ?>
		<div id="j-main-container">
			<?php endif; ?>


			<div class="clearfix"></div>
			<table class="table table-striped" id="">
				<thead>
				
				</thead>
				<tfoot>
				<tr>
					
				</tr>
				</tfoot>
				<tbody>
				
				</tbody>
			</table>
			

			<input type="hidden" name="task" value=""/>
			<input type="hidden" name="boxchecked" value="0"/>
            <input type="hidden" name="list[fullorder]" value="<?php echo $listOrder; ?> <?php echo $listDirn; ?>"/>
			<?php echo JHtml::_('form.token'); ?>
		</div>
</form>
<script>
    window.toggleField = function (id, task, field) {

        var f = document.adminForm, i = 0, cbx, cb = f[ id ];

        if (!cb) return false;

        while (true) {
            cbx = f[ 'cb' + i ];

            if (!cbx) break;

            cbx.checked = false;
            i++;
        }

        var inputField   = document.createElement('input');

        inputField.type  = 'hidden';
        inputField.name  = 'field';
        inputField.value = field;
        f.appendChild(inputField);

        cb.checked = true;
        f.boxchecked.value = 1;
        window.submitform(task);

        return false;
    };
</script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!--<center>
<div id="form_sample">
<form name="uploadform" >
<input type="file" name="file_upload" required/>
        <br>
		<input id="ast" type="text" name="description" placeholder="Descripcion" required />
        <br>
        <button type="button" onclick="proceed();">Cargar archivo</button>
</form>
</div>




<input type="button" id="boton" value="Cargar HTML externo">

<div id="cargaexterna">Aquí se cargará el HTML externo</div>


</center>-->
<!--
<center>

<form method="post" id="formulario" enctype="multipart/form-data">
		
        <input type="file" name="upfile" class="inputValidate"/>
		<input type="text" name="description" class="inputValidate" placeholder="Descripcion"/>
		
        <br>

<td></td><td><input type="button" id="btn_enviar" value="Buscar nombre"></td>


</form>
<div id="respuesta">
</div>
</center>-->
<center>

<form id="file-form" action="index.php?option=com_layoutpoint&task=uploadfiles.upload" method="post" enctype="multipart/form-data">
        Selecciona un archivo:
        <input type="file" id="myfile" name="myfile" required>
        <br>
        <input type="text" name="description" placeholder="Descripcion" required>
        <br>
        <input type="submit" id="submit" name="submit" value="Cargar" class="btn" >
    </form>

    </center>



<script>

   /*
$(function(){
 $("#btn_enviar").click(function(){
 	var validado = true;
	$(".inputValidate").each(function(){;
  		if($(this).val() == ""){
	 		alert("El campo "+$(this).attr('name')+" vacio");
	 		validado = false;
	 		return false;
	 	}
	});
	if(validado === true){
		var url = "index.php?option=com_layoutpoint&task=uploadfiles.upload"; // El script a dónde se realizará la petición.
    $.ajax({
           type: "POST",
           url: url,
           data: $("#formulario").serialize(), // Adjuntar los campos del formulario enviado.
           success: function(data)
           {
               $("#respuesta").html(data); // Mostrar la respuestas del script PHP.
           }
         });		
	}
    return false; // Evitar ejecutar el submit del formulario.
 });
});*/
</script>


<script>
/*$(document).ready(function()
{
$("#boton").click(function(){
        $.post("index.php?option=com_layoutpoint&task=uploadfiles.upload",{coche: "Ford", modelo: "Focus", color: "rojo"}, function(htmlexterno){
   $("#cargaexterna").html(htmlexterno);
    	});
});
});*/


/*function proceed () {
	var x = document.forms["uploadform"]["description"].value;
	var y = document.forms["uploadform"]["file_upload"].value;
    if (x == "" | y == "") {
        alert("Debes completar todos los campos");
        return false;
    }
    var x = document.getElementById("form_sample");
    alert(x);
    var form = document.createElement('form');
    form.setAttribute('method', 'post');
    form.setAttribute('action', 'index.php?option=com_layoutpoint&task=uploadfiles.upload');
    form.style.display = 'hidden';
    x.appendChild(form);
    document.body.appendChild(form)
    form.submit();
}*/
</script>