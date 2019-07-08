    <?php
/**
 * @version    1.0.0
 * @package    COM_CART
 * @author     Zitdev <>
 * @copyright  Zitdev (C) 2017. All rights reserved.
 * @license
 */

// No direct access
defined('_JEXEC') or die;

//JHtml::addIncludePath(JPATH_COMPONENT . '/helpers/');

    JHtml::_('behavior.tooltip');
    JHtml::_('behavior.formvalidation');
    JHtml::_('formbehavior.chosen', 'select');
    JHtml::_('behavior.keepalive');

    $user      = JFactory::getUser();
    $userId    = $user->get('id');
    $listOrder = $this->state->get('list.ordering');
    $listDirn  = $this->state->get('list.direction');
    $canOrder  = $user->authorise('core.edit.state', 'com_perfil');
    $sortFields = $this->getSortFields();

?>
    <form action="<?php echo JRoute::_('index.php?option=com_perfil&view=perfiles'); ?>" method="post" name="adminForm" id="adminForm">

        <div id="j-sidebar-container" class="span2">
            <?php //echo $this->sidebar; ?>
        </div>

        <div id="j-main-container">
            <div class="clearfix"></div>
            <!-- Búsqueda y ordenamiento-->
            <div id="filter-bar" class="btn-toolbar">
                <!--Buscador -->
                <div class="filter-search btn-group pull-left">
                    <label for="filter_search" class="element-invisible">
                        <?php echo JText::_('COM_CATALOG_SEARCH_IN_TITLE');?>'
                    </label>
                    <input type="text" name="filter_search" id="filter_search" placeholder="<?php echo JText::_('COM_CATALOG_SEARCH_IN_TITLE'); ?>" value="<?php echo $this->escape($this->state->get('filter.search')); ?>" title="<?php echo JText::_('COM_CATALOG_SEARCH_IN_TITLE'); ?>" />
                </div>
                <!--Ordenamiento-->

                <div class="btn-group pull-left">
                    <button class="btn hasTooltip" type="submit" title="<?php echo JText::_('JSEARCH_FILTER_SUBMIT'); ?>"><i class="icon-search"></i></button>
                    <button class="btn hasTooltip" type="button" title="<?php echo JText::_('JSEARCH_FILTER_CLEAR'); ?>" onclick="document.id('filter_search').value='';this.form.submit();">
                        <i class="icon-remove"></i></button>
                </div>

                <div class="btn-group pull-right hidden-phone">

                    <select class="span12 small" onchange="document.adminForm.type_filter.value=this.value; Joomla.submitform();return false;">
                    <?php echo $this->extra_sidebar?>

                </select>
                </div>



                <div class="btn-group pull-right hidden-phone">
                    <label for="directionTable" class="element-invisible">
                        <?php echo JText::_('JFIELD_ORDERING_DESC');?>
                    </label>
                    <select name="directionTable" id="directionTable" class="input-medium" onchange="Joomla!.orderTable()">
                        <option value=""><?php echo JText::_('JFIELD_ORDERING_DESC');?></option>
                        <option value="asc" <?php if ($listDirn == 'asc') echo 'selected="selected"'; ?>>
                            <?php echo JText::_('JGLOBAL_ORDER_ASCENDING');?>
                        </option>
                        <option value="desc" <?php if ($listDirn == 'desc') echo 'selected="selected"'; ?>>
                            <?php echo JText::_('JGLOBAL_ORDER_DESCENDING');?>
                        </option>
                    </select>
                </div>

                <div class="btn-group pull-right">
                    <label for="sortTable" class="element-invisible"><?php echo JText::_('JGLOBAL_SORT_BY');?></label>
                    <select name="sortTable" id="sortTable" class="input-medium" onchange="Joomla!.orderTable()">
                        <option value=""><?php echo JText::_('JGLOBAL_SORT_BY');?></option>
                        <?php echo JHtml::_('select.options', $sortFields, 'value','text', $listOrder);?>
                    </select>
                </div>

                <!--Cantidad de elementos a mostrar en cada pagina {paginación}-->
                <div class="btn-group pull-right hidden-phone">
                    <label for="limit" class="element-invisible">
                        <?php echo JText::_('JFIELD_PLG_SEARCH_SEARCHLIMIT_DESC');?>
                    </label>
                    <?php echo $this->pagination->getLimitBox(); ?>
                </div>
            </div>


            <table class="table table-striped" id="userList">
                <caption><h4><?php echo JText::_('COM_PERFIL_USERS');?></h4></caption>
                <thead>
                <th><?php echo JText::_('COM_PERFIL_NAME_LABEL');?></th>
                <th><?php echo JText::_('COM_PERFIL_USERNAME');?></th>
                <th><?php echo JText::_('COM_PERFIL_EMAIL_LABEL');?></th>
                <th><?php echo JText::_('COM_PERFIL_CELLPHONE_LABEL');?></th>
                <th><?php echo JText::_('COM_PERFIL_COMPONENT_DATACOMPLATE');?></th>
                <th></th>
                <th>Editar</th>
                </thead>

                <tbody>
                <?php foreach ($this->items as $i => $item) :?>
                    <tr>
                        <td>
                            <?php echo $item->name ?>
                        </td>
                        <td>
                            <?php echo $item->username ?>
                        </td>
                        <td>
                            <?php echo $item->email ?>
                        </td>
                        <td>
                            <?php echo $item->cellphone ?>
                        </td>
                        <td>
                            <?php if ($item->complete_data==0): ?>
                                <span class="badge badge-danger" id="complete-data-<?php echo $item->id?>">No</span>
                            <?php else:; ?>
                                <span class="badge badge-success" id="complete-data-<?php echo $item->id?>">Si</span>

                            <?php endif; ?>


                        </td>
                        <td>

                            <?php if ($item->complete_data==1): ?>
                                <button data-status="<?php echo $item->complete_data?>"   data-id="<?php echo $item->id?>" id="btnUsuario-<?php echo $item->id?>" onclick="activarUsuario(<?php echo $item->id?>,1)" class="btn btn-success">
                                    <?php echo JText::_('COM_PERFIL_BTN');?>
                                </button>

                            <?php else:; ?>

                                <button data-status="<?php echo $item->complete_data?>" data-id="<?php echo $item->id?>" id="btnUsuario-<?php echo $item->id?>" onclick="activarUsuario(<?php echo $item->id?>,0)" class="btn btn-success">
                                    <?php echo JText::_('COM_PERFIL_BTN');?>
                                </button>
                            <?php endif; ?>


                        </td>
                        <td>

                            <a href="<?php echo JRoute::_('index.php?option=com_perfil&view=perfil&layout=edit&&id='.(int) $item->id); ?>">
                                <span class="icon-edit" aria-hidden="true"></span>

                            </a>
                        </td>
                    </tr>

                <?php endforeach; ?>
                </tbody>
                <tfoot>
                <tr>
                    <td colspan="10">
                        <?php echo $this->pagination->getListFooter(); ?>
                    </td>
                </tr>


                </tfoot>

            </table>

            <?   echo JHtmlSelect::booleanlist('published',null,true,'Yes','No')?>

            <input type="hidden" name="task" value="perfiles" />
            <input type="hidden" name="type_filter" value="" />
            <input type="hidden" name="boxchecked" value="0" />
            <input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>" />
            <input type="hidden" name="filter_order_Dir" value="<?php echo $listDirn; ?>" />
            <?php echo JHtml::_('form.token'); ?>


        </div>

    </form>

