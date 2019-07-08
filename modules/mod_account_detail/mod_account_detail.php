<?php
    // no direct access
    defined('_JEXEC') or die;

    // include the syndicate functions only once
    require_once __DIR__.'/helper.php';

    $document = JFactory::getDocument();
    $document->addStyleSheet("modules/mod_account_detail/assets/css/estilos.css");
    $document->addStyleSheet("modules/mod_account_detail/assets/css/bootstrap.min.css");
    $document->addScript("modules/mod_account_detail/assets/js/jquery.min.js");
    $document->addScript("modules/mod_account_detail/assets/js/script.js");
    $helper = new  ModAccountDetailHelper;

    $user = JFactory::getUser();

    $user_info = $fields = $points = array();
    JText::script('MOD_ACCOUNT_BTN_DETAILS');
    JText::script('MOD_ACCOUNT_DETAIL_FRONT_PUNTOSCANJEHIDE');


$data_transaction=$helper->getAllDataUser();
    $months=array(
    '01'=>'Enero',
    '02'=>'Febrero',
        '03'=>'Marzo',
        '04'=>'Abril',
        '05'=>'Mayo',
        '06'=>'Junio',
        '07'=>'Julio',
        '08'=>'Agosto',
        '09'=>'Septiembre',
        '10'=>'Octubre',
        '11'=>'Noviembre',
        '12'=>'Diciembre'

);


// Get point types

    require(JModuleHelper::getLayoutPath('mod_account_detail', $params->get('layout', 'default')));