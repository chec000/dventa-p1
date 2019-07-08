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
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                        <tr class="tabla">
                            <th>#</th>
                            <th><?= JText::_('MOD_ACCOUNT_DETAIL_FRONT_POINT_TICKET'); ?></th>
                            <th><?= JText::_('MOD_ACCOUNT_DETAIL_FRONT_POINT_ANIO'); ?></th>
                            <th><?= JText::_('MOD_ACCOUNT_DETAIL_FRONT_POINT_MONTH'); ?></th>
                            <th><?= JText::_('MOD_ACCOUNT_DETAIL_FRONT_FECHACOMPRA'); ?></th>
                            <th><?= JText::_('MOD_ACCOUNT_DETAIL_FRONT_FECHAPAGO'); ?></th>
                            <th><?= JText::_('MOD_ACCOUNT_DETAIL_FRONT_MONTO'); ?></th>
                            <th><?= JText::_('MOD_ACCOUNT_DETAIL_FRONT_PUNTOS'); ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if (!empty($data_transaction['data_complate'])) : ?>
                            <td><?php $index=1;
                                $monto_total=0;
                                $punton_acumulados=0;
                                ?></td>
                            <?php foreach ($data_transaction['data_complate'] as $item) : ?>
                                <tr>
                                    <td><?php echo $index ?></td>
                                    <td><?php echo  $item['ticket']?></td>
                                    <td><?php echo trim($item['year']); ?></td>
                                    <td><?php echo trim($months[$item['month']]); ?></td>
                                    <td><?php echo    $item['fecha_compra']?></td>
                                    <td><?php echo    $item['fecha_pago']?></td>
                                    <td><?php echo   $item['monto']?></td>
                                    <td><?php echo    $item['puntos']?></td>

                                </tr>
                                <td><?php
                                    $index++;
                                    $monto_total=$monto_total+$item['monto'];
                                    $punton_acumulados=$punton_acumulados+$item['puntos'];
                                    ?></td>
                            <?php endforeach; ?>
                        <?php endif; ?>
                        </tbody>
                        <tfoot>
                        <tr>
                            <td></td>
                            <td></td>
                            <td> </td>
                            <td></td>
                            <td></td>
                            <td class="tabla2">
                                <?= JText::_('MOD_ACCOUNT_DETAIL_FRONT_POINT_MONTO'); ?>
                            </td>
                            <td class="tabla2">
                                <?php
                                echo $monto_total;
                                ?>
                            </td>
                            <td class="tabla2">
                                <?php
                                echo $punton_acumulados;
                                ?>

                            </td>
                        </tr>
                        </tfoot>
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


