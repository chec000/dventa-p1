<?php
/**
 * @copyright	Copyright (c) 2017 Adventa (http://www.adventa.com.mx/). All rights reserved.
 * @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

// no direct access
defined('_JEXEC') or die;
$actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
if (count($orders)>0) { 
?>
<div style="overflow:auto;border:1px solid lightgray;">
<table class="table table-striped" id="articleList">
    <tbody class="bodycontent">
        <thead class="table_header">
            <tr>
                <td><?php echo JText::_('MOD_HISTORIAL_CANJE_ORDER_NUMBER_LABEL'); ?></td>
                <td><?php echo JText::_('MOD_HISTORIAL_CANJE_CREATION_DATE_LABEL'); ?></td>
                <td><?php echo JText::_('MOD_HISTORIAL_CANJE_PRODUCT_QUANTITY_LABEL'); ?></td>
                <td><?php echo JText::_('MOD_HISTORIAL_CANJE_TOTAL_LABEL'); ?></td>
                <td><?php echo JText::_('MOD_HISTORIAL_CANJE_ACTIONS_LABEL'); ?></td>
            </tr>
        </thead>
       
        <?php 
            $cnt = 1;
            foreach ($orders as $item) { 
        ?>
        <tr class="ms_row<?php echo ($cnt%2); ?>"> 
            <td>
                <?php echo $item->id; ?>
            </td> 
            <td> 
                <?php echo $item->created_at; ?>
            </td>
            <td> 
                <?php $order_id = $item->id;
                echo $countOrderItems->$order_id; ?>
            </td>
            <td> 
                <?php echo number_format($item->total); ?>
            </td>
            <td>
            <a href='<?php echo $actual_link.'?o_id='.$order_id; ?>' title="Detalle de canje" aria-label="">
                <span class="fa fa-fw fa-align-justify"></span>                
                <span class="g-social-text"></span>            
            </a>
            <!--<a href='<?php echo $actual_link.'?pdf='.$order_id; ?>' target="_blank" title="Descargar PDF" aria-label="">
                <span class="fa fa-fw fa-download"></span>                
                <span class="g-social-text"></span>
                         
            </a>-->
            </td>
        </tr>
        <?php $cnt++; } ?>
    </tbody>
</table>
</div>
<?php } else { ?> <div style="border:none;">Ningún elemento encontrado.</div> <?php } ?>