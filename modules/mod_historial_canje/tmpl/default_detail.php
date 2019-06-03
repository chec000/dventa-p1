<?php
/**
 * @copyright	Copyright (c) 2017 Adventa (http://www.adventa.com.mx/). All rights reserved.
 * @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

// no direct access
defined('_JEXEC') or die;
$order_id = $_GET['o_id'];  
?>
<h3>Detalle de canje #<?php echo $order_id ?></h3>
<button onclick="history.go(-1);" class="button button-small">Regresar</button>

<h3>Número de orden:</h3>
<h4><?php echo $order_id;?></h4>
<h3>Fecha de orden:</h3>
<h4><?php echo $orderDetails->$order_id->created_at; ?></h4>




<div style="overflow:auto;border:1px solid lightgray;">
<table class="table table-striped" id="articleList">
    
    <tbody class="bodycontent">
        <thead class="table_header">
            <tr>
                <td>Producto</td>
                <td>SKU</td>
                <td>Precio</td>
                <td>Cantidad</td>
                <td>Total</td>
            </tr>
        </thead>
        
        <?php 
            $cnt = 1;
            $total_cost =0;
            foreach ($ordersbyid->$order_id as $item) { 
            
        ?>
        <tr class="ms_row<?php echo ($cnt%2); ?>"> 
            
            <td> 
                <?php echo $item->title; ?>
            </td>
            <td> 
                <?php echo $item->sku; ?>
            </td>
            
            <td> 
                <?php echo number_format($item->price); ?>
            </td>

            <td> 
                <?php echo $item->quantity; ?>
            </td>

            <td>
                <?php 
                $product_sum = $item->quantity*$item->price;
          
                echo number_format($product_sum);
                $total_cost += $product_sum;?>
            </td>
            
        </tr>
        <?php $cnt++; } ?>
        
    </tbody>
</table>
<div>Total: <?php echo number_format($total_cost); ?></div>
</div>
