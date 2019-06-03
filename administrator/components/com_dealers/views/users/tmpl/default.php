<?php
defined('_JEXEC') or die;

$user = JFactory::getUser();
//Ordenamientos
$listOrder = $this->escape($this->state->get('list.ordering'));
$listDirn = $this->escape($this->state->get('list.direction'));

$sortFields = $this->getSortFields();
?>
<form action="<?php echo JRoute::_('index.php?option=com_dealers&view=users'); ?>" method="post" name="adminForm" id="adminForm">
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
        <?php echo JText::_('COM_DEALERS_SEARCH_IN_USERS');?>
      </label>
      <input type="text" name="filter_search" id="filter_search" placeholder="<?php echo JText::_('COM_DEALERS_SEARCH_IN_USERS'); ?>" value="<?php echo $this->escape($this->state->get('filter.search')); ?>" title="<?php echo JText::_('COM_DEALERS_SEARCH_IN_USERS'); ?>" />
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
    </div>

    <!-- Grid principal-->
      <div class="clearfix"> </div>
      <table class="table table-striped" id="dealersList">
        <thead>
          <tr>
            <th class="hidden-phone" width="1%">
              <input type="checkbox" name="checkall-toggle" value="" title="<?php echo JText::_('JGLOBAL_CHECK_ALL'); ?>" onclick="Joomla.checkAll(this)" />
            </th>
            <th class="username">
              <?php echo JHtml::_('grid.sort', 'COM_DEALERS_HEADING_USER', 'u.userid', $listDirn, $listOrder); ?>
            </th>
            <th class="user">
              <?php echo JHtml::_('grid.sort', 'COM_DEALERS_HEADING_USERNAME', 'u.name', $listDirn, $listOrder); ?>
            </th>
            <th class="idcedis">
              <?php echo JHtml::_('grid.sort', 'COM_DEALERS_HEADING_IDCEDIS','a.cedis_id', $listDirn, $listOrder); ?>
            </th>
            <th class="names_cedis">
              <?php echo JHtml::_('grid.sort', 'COM_DEALERS_HEADING_CEDIS', 'a.names_cedis', $listDirn, $listOrder); ?>
            </th>
            <th class="nowrap center hidden-phone" width="1%">
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
                  $canChange = $user->authorise('core.edit.state', 'com_dealers') && $canCheckin;
                  $canEdit = $user->authorise('core.edit', 'com_dealers');
            ?>
            <tr class="row<?php echo $i % 2; ?>" sortable-group-id="1">
              <td class="center hidden-phone">
                <?php echo JHtml::_('grid.id', $i, $item->mapid); ?>
              </td>
              <td >
                <?php if ($canEdit) : ?>
                <a href="<?php echo JRoute::_('index.php?option=com_dealers&task=user.edit&id='.(int) $item->mapid); ?>">
                  <?php echo $this->escape($item->username); ?>
                </a>
              <?php else : ?>
                <?php echo $this->escape($item->username); ?>
              <?php endif; ?>
              </td>
              <td>
                <?php echo $this->escape($item->name); ?>
              </td>
              <td>
                <?php echo $this->escape($item->cedisid); ?>
              </td>
              <td>
                <?php echo $item->names_cedis; ?>
              </td>
              <td class="center hidden-phone">
                <?php echo (int) $item->mapid; ?>
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
