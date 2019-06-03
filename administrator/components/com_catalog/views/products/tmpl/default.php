<?php  
defined('_JEXEC') or die('Restricted access'); 

    //Ordenamientos
$listOrder = $this->escape($this->state->get('list.ordering'));
$listDirn = $this->escape($this->state->get('list.direction'));
$sortFields = $this->getSortFields();
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
JHtml::_('formbehavior.chosen', 'select');
JHtml::_('behavior.keepalive');
?>

<div id="j-sidebar-container" class="span2">
  <?php echo $this->sidebar; ?>
</div>
<div id="j-main-container" class="span10">
  <form action="<?php echo JRoute::_('index.php?option=com_catalog&view=products'); ?>"
    method="post" name="adminForm" id="adminForm">
    <!--Tabla principal-->

    <!-- Búsqueda y ordenamiento-->
    <div id="filter-bar" class="btn-toolbar">
      <!--Buscador -->
      <div class="filter-search btn-group pull-left">
        <label for="filter_search" class="element-invisible">
          <?php echo JText::_('COM_CATALOG_SEARCH_IN_TITLE');?>'
        </label>
        <input type="text" name="filter_search" id="filter_search" placeholder="<?php echo JText::_('COM_CATALOG_SEARCH_IN_TITLE'); ?>" value="<?php echo $this->escape($this->state->get('filter.search')); ?>" title="<?php echo JText::_('COM_CATALOG_SEARCH_IN_TITLE'); ?>" />
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
    

    <table class="table table-striped" id="productsList" data-order='[[ 1, "<?php echo $listOrder?>" ]]'>
      <thead>
        <tr>
          <th></th>
          <th width="2%" class="nowrap center hidden-phone">
            <?php echo JHtml::_('grid.sort', 'PRODUCTS_ID','a.id', $listDirn, $listOrder); ?>
          </th>          
          <th class="product_title" width="15%">
            <?php echo JHtml::_('grid.sort', 'PRODUCTS_TITLE', 'a.title', $listDirn, $listOrder); ?>
          </th>
          <th class="product_sku">
            <?php echo JHtml::_('grid.sort', 'PRODUCTS_SKU','a.sku', $listDirn, $listOrder); ?>
          </th>
          <th lass="product_description">
            <?php echo JHtml::_('grid.sort', 'PRODUCTS_DESCRIPTION', 'a.description', $listDirn, $listOrder); ?>
          </th>        
          <th width="10%" class="product_img">
            <?php echo JHtml::_('grid.sort', 'PRODUCTS_IMAGE','a.file_name', $listDirn, $listOrder); ?>
          </th>        
          <th class="product_price">
            <?php echo JHtml::_('grid.sort', 'PRODUCTS_PRICE','a.price', $listDirn, $listOrder); ?>
          </th>
          <th class="product_like">
            <?php echo JHtml::_('grid.sort', 'PRODUCTS_LIKE','likeF', $listDirn, $listOrder); ?>
          </th>
          <th class="product_dislike">
            <?php echo JHtml::_('grid.sort', 'PRODUCTS_DISLIKE','dislikeF', $listDirn, $listOrder); ?>
          </th>
        </thead>
        <tbody>
          <?php foreach ($this->items as $i => $item):?>      
            <tr class="row<?php echo $i % 2; ?>" sortable-group-id="1"> 
              <td>
                <input type="radio" 
                id="cb<?php echo $item->id?>" 
                name="cid" value="<?php echo $item->id?>" 
                onclick="Joomla.isChecked(this.checked);" 
                title=""/>
              </td>
              <td>
                <?php echo $item->id; ?>
              </td>                       
              <td>
               <?php echo $item->title; ?>
             </td>   
             <td>
              <?php echo $item->sku; ?>
            </td>              
            <td>
              <?php echo $item->description; ?>
            </td>             
            <td>
              <img src="<?php echo JRoute::_('../images/productos/'.$item->file_name); ?>">
            </td>              
            <td>
              <?php echo number_format($item->price); ?>
            </td> 
            <td>
              <?php echo number_format($item->likeF); ?>
            </td> 
            <td>
              <?php echo number_format($item->dislikeF); ?>
            </td> 
          </tr>
        <?php endforeach; ?>             
      </tbody>
      
      <!--Paginación -->
      <tfoot>
        <tr>
          <td colspan="10">
            <?php echo $this->pagination->getListFooter(); ?>
          </td>
        </tr>
      </tfoot>

    </table>

    <input type="hidden" name="task" value="products" />
    <input type="hidden" name="boxchecked" value="0" />
    <input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>" />
    <input type="hidden" name="filter_order_Dir" value="<?php echo $listDirn; ?>" />
    <?php echo JHtml::_('form.token'); ?> 
  </form>
</div>