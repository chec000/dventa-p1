<?php
defined('_JEXEC') or die;

  $user = JFactory::getUser();

  //Ordenamientos
  $listOrder = $this->escape($this->state->get('list.ordering'));
  $listDirn = $this->escape($this->state->get('list.direction'));

  //Verificar si el usuario tiene permiso de ordenar
  $canOrder = $user->authorise('core.edit.state', 'com_mecanicas');

  //Checar si se esta ordenando con la columna de ordenamiento, necesitamos saber si el ordenamiento por drag&drop estará habilitado o des-habilitado
  $saveOrder = $listOrder == 'a.ordering';

  if ($saveOrder)
  {
    $saveOrderingUrl = 'index.php?option=com_mecanicas&task=mecanicas.saveOrderAjax&tmpl=component';
    JHtml::_('sortablelist.sortable', 'mecanicasList', 'adminForm', strtolower($listDirn), $saveOrderingUrl);
  }

  $sortFields = $this->getSortFields();
  ?>

<script type="text/javascript">
    Joomla!.orderTable = function()
    {
      table = document.getElementById("sortTable");
      direction = document.getElementById("directionTable");
      order = table.options[table.selectedIndex].value;

      if (order != '<?php echo $listOrder; ?>')
      {
        dirn = 'asc';
      }
      else
      {
        dirn = direction.options[direction.selectedIndex].value;
      }
        Joomla!.tableOrdering(order, dirn, '');
      }
</script>

<form action="<?php echo JRoute::_('index.php?option=com_mecanicas&view=mecanicas'); ?>" method="post" name="adminForm" id="adminForm">
<!-- filtros sidebar-->
  <?php if (!empty( $this->sidebar)) : ?>
    <div id="j-sidebar-container" class="span2">
      <?php echo $this->sidebar; ?>
    </div>
    <div id="j-main-container" class="span10">
  <?php else : ?>
    <div id="j-main-container">
  <?php endif;?>

  <!-- Búsqueda y ordenamiento-->
  <div id="filter-bar" class="btn-toolbar">
    <!--Buscador -->
    <div class="filter-search btn-group pull-left">
      <label for="filter_search" class="element-invisible">
        <?php echo JText::_('COM_MECANICAS_SEARCH_IN_CONTENT');?>
      </label>
      <input type="text" name="filter_search" id="filter_search" placeholder="<?php echo JText::_('COM_MECANICAS_SEARCH_IN_CONTENT'); ?>" value="<?php echo $this->escape($this->state->get('filter.search')); ?>" title="<?php echo JText::_('COM_MECANICAS_SEARCH_IN_CONTENT'); ?>" />
    </div>
    <div class="btn-group pull-left">
      <button class="btn hasTooltip" type="submit" title="<?php echo JText::_('JSEARCH_FILTER_SUBMIT'); ?>"><i class="icon-search"></i></button>
      <button class="btn hasTooltip" type="button" title="<?php echo JText::_('JSEARCH_FILTER_CLEAR'); ?>" onclick="document.id('filter_search').value='';this.form.submit();"><i class="icon-remove"></i></button>
    </div>

    <!--Cantidad de elementos a mostrar en cada pagina {paginación}-->
    <div class="btn-group pull-right hidden-phone">
      <label for="limit" class="element-invisible">
        <?php echo JText::_('JFIELD_PLG_SEARCH_SEARCHLIMIT_DESC');?>
      </label>
      <?php echo $this->pagination->getLimitBox(); ?>
    </div>

    <!-- Ordenamientos -->
    <?php
    // Trabaja en la con la funcion getSortFields definida en el view.html.php
    ?>
    <div class="btn-group pull-right hidden-phone">
      <label for="directionTable" class="element-invisible">
        <?php echo JText::_('JFIELD_ORDERING_DESC');?>
      </label>
      <select name="directionTable" id="directionTable" class="input-medium" onchange="Joomla!.orderTable()">
        <option value=""><?php echo JText::_('JFIELD_ORDERING_DESC');?></option>
        <option value="asc" <?php if ($listDirn == 'asc') echo 'selected="selected"'; ?>><?php echo JText::_('JGLOBAL_ORDER_ASCENDING');?></option>
        <option value="desc" <?php if ($listDirn == 'desc') echo 'selected="selected"'; ?>><?php echo JText::_('JGLOBAL_ORDER_DESCENDING');?></option>
      </select>
    </div>
    <div class="btn-group pull-right">
      <label for="sortTable" class="element-invisible"><?php echo JText::_('JGLOBAL_SORT_BY');?></label>
      <select name="sortTable" id="sortTable" class="input-medium" onchange="Joomla!.orderTable()">
        <option value=""><?php echo JText::_('JGLOBAL_SORT_BY');?></option>
          <?php echo JHtml::_('select.options', $sortFields, 'value','text', $listOrder);?>
        </select>
      </div>
  </div>

<!-- Grid principal-->
  <div class="clearfix"> </div>
  <table class="table table-striped" id="mecanicasList">
    <thead>
      <tr>
        <th width="1%" class="nowrap center hidden-phone">
          <?php echo JHtml::_('grid.sort', '<i class="iconmenu-2"></i>', 'a.ordering', $listDirn, $listOrder, null, 'asc','JGRID_HEADING_ORDERING'); ?>
        </th>
        <th width="1%" class="hidden-phone">
          <input type="checkbox" name="checkall-toggle" value="" title="<?php echo JText::_('JGLOBAL_CHECK_ALL'); ?>" onclick="Joomla.checkAll(this)" />
        </th>
        <th width="1%" style="min-width:55px" class="nowrap center">
          <?php echo JHtml::_('grid.sort', 'JSTATUS', 'a.state', $listDirn, $listOrder); ?>
        </th>
        <th class="idmecanica">
          <?php echo JHtml::_('grid.sort', 'COM_MECANICAS_HEADING_GROUPID','a.id', $listDirn, $listOrder); ?>
        </th>
        <th width="1%" class="nowrap center hidden-phone">
          <?php echo JHtml::_('grid.sort', 'JGRID_HEADING_ID','a.id', $listDirn, $listOrder); ?>
        </th>
    </thead>

    <!--Paginación -->
    <tfoot>
      <tr>
        <td colspan="10">
          <?php echo $this->pagination->getListFooter(); ?>
        </td>
      </tr>
    </tfoot>

    <tbody>
      <?php foreach ($this->items as $i => $item) :
              $canCheckin = $user->authorise('core.manage', 'com_checkin');
              $canChange = $user->authorise('core.edit.state', 'com_mecanicas') && $canCheckin;
              $canEdit = $user->authorise('core.edit', 'com_mecanicas');
        ?>
        <tr class="row<?php echo $i % 2; ?>" sortable-group-id="1">
          <td class="order nowrap center hidden-phone">
            <?php if ($canChange) : $disableClassName = '';
                      $disabledLabel = '';
                  if (!$saveOrder) :
                    $disabledLabel = JText::_('JORDERINGDISABLED');
                    $disableClassName = 'inactive tip-top';
                  endif; ?>
            <span class="sortable-handler hasTooltip <?php echo $disableClassName?>" title="<?php echo $disabledLabel?>">
              <i class="icon-menu"></i>
            </span>
            <input type="text" style="display:none" name="order[]" size="5" value="<?php echo $item->ordering;?>" class="width-20 textarea-order " />
            <?php else : ?>
              <span class="sortable-handler inactive" >
                <i class="icon-menu"></i>
              </span>
            <?php endif; ?>
          </td>
          <td class="center hidden-phone">
            <?php echo JHtml::_('grid.id', $i, $item->id); ?>
          </td>
          <td class="center">
            <?php echo JHtml::_('jgrid.published', $item->state, $i,'mecanicas.', $canChange, 'cb', $item->publish_up, $item->publish_down); ?>
          </td>
          <td class="nowrap has-context">
            <?php if ($canEdit) : ?>
            <a href="<?php echo JRoute::_('index.php?option=com_mecanicas&task=mecanica.edit&id='.(int) $item->id); ?>">
              <?php echo $this->escape( $item->groupname); ?>
            </a>
          <?php else : ?>
            <?php echo $this->escape( $item->levelname); ?>
          <?php endif; ?>
          </td>
          <td class="center hidden-phone">
            <?php echo (int) $item->id; ?>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>

  <input type="hidden" name="task" value="" />
  <input type="hidden" name="boxchecked" value="0" />
  <input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>" />
  <input type="hidden" name="filter_order_Dir" value="<?php echo $listDirn; ?>" />
<!-- Protejer de ataques CSRF-->
  <?php echo JHtml::_('form.token'); ?>
  </div>
</form>
