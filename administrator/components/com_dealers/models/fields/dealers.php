<?php
defined('_JEXEC') or die;

JFormHelper::loadFieldClass('list');

class JFormFieldDealers extends JFormFieldList {

  //Indicamos que es un tipo personalizado
	protected $type = 'Dealers';

  public function getOptions()
  {

    $db = JFactory::getDbo();

  $query = $db->getQuery(true)
              ->select('a.cedis_id, a.names_cedis')
              ->from('`#__core_cedis` AS a')
              ->where('a.state = 1');

		$rows = $db->setQuery($query)->loadObjectlist();

    $options[] = JHtml::_('select.option', '', 'Seleccione...');

    foreach($rows as $row){
      $options[] = JHtml::_('select.option', $row->cedis_id, $row->names_cedis);
    }

    // Merge any additional options in the XML definition.
		$options = array_merge(parent::getOptions(), $options);

    return $options;

	}

}
