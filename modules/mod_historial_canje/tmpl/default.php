<?php
/**
 * @copyright	Copyright (c) 2017 Adventa (http://www.adventa.com.mx/). All rights reserved.
 * @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

// no direct access
defined('_JEXEC') or die;
$order_id = null;
$pdf_id = null;
$flag_detail=0;
$flag_pdf=0;
if (isset($_GET['o_id']) !='' || isset($_GET['o_id']) !=NULL){
    for($i=0;$i<count($orders);$i++){
        if($_GET['o_id'] == $orders[$i]->id){
            $flag_detail=1;
        }
    }
    if($flag_detail == 1){
        $order_id = $_GET['o_id']; 
    }else{
        $order_id=null;
    }
}
if (isset($_GET['pdf']) !='' || isset($_GET['pdf']) !=NULL){
    for($i=0;$i<count($orders);$i++){
        if($_GET['pdf'] == $orders[$i]->id){
            $flag_detail=1;
        }
    }
    if($flag_detail == 1){
        $pdf_id = $_GET['pdf']; 
    }else{
        $pdf_id=null;
    }
}

if ($order_id != '' && $order_id != null){
    ?>
        <div>
            <?php require JModuleHelper::getLayoutPath('mod_historial_canje', $params->get('layout', 'default') . '_detail'); ?>
        </div>
    <?php
}else if($pdf_id != '' && $pdf_id != null){
    ?>
        <div>
            <?php require JModuleHelper::getLayoutPath('mod_historial_canje', $params->get('layout', 'default') . '_pdf'); ?>
        </div>
    <?php
}else{
    ?>
        <div>
            <?php require JModuleHelper::getLayoutPath('mod_historial_canje', $params->get('layout', 'default') . '_items'); ?>
        </div>
    <?php
}
?>


