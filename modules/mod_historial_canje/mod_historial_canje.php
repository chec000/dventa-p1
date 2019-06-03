<?php
/**
 * @copyright	@copyright	Copyright (c) 2017 Adventa (http://www.adventa.com.mx/). All rights reserved.
 * @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

// no direct access
defined('_JEXEC') or die;

// include the syndicate functions only once
require_once __DIR__ . '/helper.php';


$class_sfx = htmlspecialchars($params->get('class_sfx'));

//EXAMPLE
$orders = modHistorial_canjeHelper::getOrders();

$countOrderItems = modHistorial_canjeHelper::countOrderItems();
$ordersbyid = modHistorial_canjeHelper::getOrderItems();
$orderDetails = modHistorial_canjeHelper::getOrderDetails();
$user = JFactory::getUser();
$cedis = modHistorial_canjeHelper::getCedis();
$cedis_value = modHistorial_canjeHelper::getCedisValue();
//Params del plugin user_profile para tomar la direccion de envío
//$plugin = JPluginHelper::getPlugin('user', 'profile');
//$params_plugin = new JRegistry($plugin->params);//Joomla 1.6 Onward

$PDF_h1="CUANDO RECIBAS TUS PREMIOS VERIFICA QUE:";
$PDF_c1="*	La caja esté en buenas condiciones (que no esté rota, golpeada, chorreada, con la cinta violada, etc.) de ser así NO RECIBAS EL PREMIO. 
*	Verifica que el premio que recibes sea el premio que canjeaste, en caso de no ser así, NO RECIBAS EL PREMIO. 
*	Se te enviará un correo electrónico con el número de guía de tu premio y fecha aproximada de entrega, si pasan más de 5 días de la fecha estimada y no has recibido tu premio, favor de avisar a contacto@tuempresa.com o llámanos al 01 800 062 0044
*	Si tu premio tiene alguna falla y/o faltantes tienes hasta 48 horas para aviso de la incidencia con evidencia (fotografía), pasando este tiempo ya no será válida la garantía en cuanto a faltantes, para las fallas tienes hasta 5 días hábiles y se te enviará la garantía del fabricante. 
*	El operador de la paquetería debe esperar a que revises tus premios recibidos y firmes de conformidad. Cualquier incidencia deberá ser notificada a contacto@tuempresa.com o al 01 800 062 0044 para darle seguimiento.";
$PDF_h2="RECUERDA QUE:";
$PDF_c2="*	Garantía de producto por incidencia:
Deberás recibir tu premio en un lapso no mayor a 30 días hábiles, en caso de rebasar estos días y no haber recibido tu premio, deberás notificar a través del correo contacto@tuempresa.com, al 01 800 062 0044 o levantando ticket en el módulo de ayuda de la página web.
Para casos de incidencias por daño de los artículos (faltante o roto) deberán ser reclamados dentro de las 48 horas a partir de la recepción del premio, enviando evidencia (fotografía) a través de los medios mencionados.
*	Garantía de producto por falla:
ADVENTA será responsable de los productos hasta 5 (cinco) días posteriores a la entrega de los mismos en caso de falla, después de este periodo la reclamación deberá ser directamente con el fabricante. 
*	Garantía por errores en entrega:
En caso de errores en la entrega del artículo, este deberá regresarse a la paquetería sin ser abierto, siempre y cuando se trate de un artículo que por su empaque, presentación o especificaciones sea susceptible de ser identificado a simple vista, de lo contrario será aceptable que el artículo haya sido abierto para su identificación,  en ambos casos se deberá dar aviso de dicha situación dentro de un periodo de 48 horas a partir de la recepción y devolución del premio escribiendo a contacto@tuempresa.com  o levantando ticket en el módulo de ayuda del portal web. El premio deberá ser entregado en su empaque original para que sea procedente la devolución.
";



require(JModuleHelper::getLayoutPath('mod_historial_canje', $params->get('layout', 'default')));

