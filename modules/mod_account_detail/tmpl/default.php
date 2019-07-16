    <?php
        // no direct access
        defined('_JEXEC') or die;
    ?>
    <?php if (count($data_transaction['data_complate'])>0) : ?>
    <div>
        <h2><?= JText::_('MOD_ACCOUNT_DETAIL_FRONT_TPL_NAME'); ?></h2>
        <!-- POINTS INFORMATION -->
        <div class="main-points">
            <div class="text-center" style="display: none">
                <p><?= JText::_('MOD_ACCOUNT_DETAIL_FRONT_PUNTOSCANJE'); ?> </p>
            </div>
            <button class="btn btn-primary" id="btnDetail" onclick="showDetail()">
                <?= JText::_('MOD_ACCOUNT_BTN_DETAILS'); ?>
            </button>
            <br>
            <div class="panel panel-default" id="demo" style="display: block;">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <?= JText::_('MOD_ACCOUNT_DETAIL_FRONT_POINT_DETAILS'); ?>
                    </h4>
                </div>
                <div class="">
                    <table class="table">
                        <thead>
                        <tr class="success">
                            <th>#</th>
                            <th><?= JText::_('MOD_ACCOUNT_DETAIL_FRONT_POINT_ANIO'); ?></th>

                            <th><?= JText::_('MOD_ACCOUNT_DETAIL_FRONT_ALL_PUNTOS'); ?></th>

                            <th><?= JText::_('MOD_ACCOUNT_DETAIL_FRONT_ALL_TICKETS'); ?></th>
                            
                            
                            <th><?= JText::_('MOD_ACCOUNT_DETAIL_FRONT_PUNTOS'); ?></th>

                            <th><?= JText::_('MOD_ACCOUNT_ACTIONS'); ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if (!empty($data_transaction['data_complate'])) : ?>
                            <td><?php $index=1;
                                ?></td>
                            <?php foreach ($data_transaction['data_complate'] as $item) : ?>
                                <tr>
                                    <td><?php echo $index ?></td>
                                    <td><?php echo trim($item['year']); ?></td>
                                    <td><?php echo trim($months[$item['month']]); ?></td>  <td><?php echo  $item['tickets']?></td>
                                    <td><?php echo  $item['points']?></td>

                                    <td>
                                        <span class="dot" onclick="showTable(this)"  data-target="#demo-<?php echo $index;?>">
                                        <i class="fa fa-plus" aria-hidden="true"></i>
                                    </span>

                                        </span>
                                       </td>

                                    
                                </tr>
                                <tr id="demo-<?php echo $index;?>" class="collapse">
                             <td colspan="6">
                                
                                <div class="table-responsive">
<table class="table table-bordered">
    <thead>
      <tr  class="success">
       <th>#</th>
        <th><?= JText::_('MOD_ACCOUNT_DETAIL_FRONT_POINT_TICKET'); ?></th>
        <th><?= JText::_('MOD_ACCOUNT_DETAIL_FRONT_FECHACOMPRA'); ?></th>
        <th><?= JText::_('MOD_ACCOUNT_DETAIL_FRONT_FECHAPAGO'); ?></th>
        <th><?= JText::_('MOD_ACCOUNT_DETAIL_FRONT_MONTO'); ?></th>
        <th><?= JText::_('MOD_ACCOUNT_DETAIL_FRONT_PUNTOS'); ?>

        </th>
      </tr>
    </thead>
    <tbody>
        <?php $j=1;?>
<?php foreach ($item['items'] as $i) : ?>
      <tr>
        <td><?php echo $j ?></td>
        <td><?php echo $i['ticket']; ?></td>
        <td><?php echo $i['fecha_compra']; ?></td>
        <td><?php echo $i['fecha_pago']; ?></td>
        <td>$<?php echo $i['monto']; ?></td>
        <td><?php echo $i['puntos']; ?></td>
      </tr>

<?php endforeach; ?>


    </tbody>
  </table>
</div>
                            </td>
                                </tr>
 

                                <?php $index++;
                                ?>
                            <?php endforeach; ?>
                        <?php endif; ?>
                        </tbody>
                        
                    </table>

                </div>
            </div>
        </div>

        <?php
        else:
        ?>
            <div>
                <?= JText::_('MOD_ACCOUNT_DETAIL_FRONT_NONE_POINTS'); ?>
            </div>

        <?php endif; ?>


