<?php
defined('_JEXEC') or die;

JFormHelper::loadFieldClass('list');

class JFormFieldUsers extends JFormFieldList {

  //Indicamos que es un tipo personalizado
	protected $type = 'Users';

  public function getOptions()
  {
		/*$valueConstraints= $this->getAssocUsers();

		if(!empty($valueConstraints))
		{
			foreach ($valueConstraints as $value) {
				$tempValConstraints[]= (int) $value->userid;
			}

			$sqlValueConstraints= implode(',',$tempValConstraints);

			$sqlAddConstraints= ' AND a.id NOT IN ('.$sqlValueConstraints.')';

		}else{
			$sqlAddConstraints='';
		}*/

		$db = JFactory::getDbo();

		$query = $db->getQuery(true)
                ->select('a.id, a.username, a.name')
                ->from('`#__users` AS a')
								->where('a.block = 0');
                //->where('a.block = 0'.$sqlAddConstraints);

		$rows = $db->setQuery($query)->loadObjectlist();

    $options[] = JHtml::_('select.option', '', 'Seleccione...');

    foreach($rows as $row){
      $options[] = JHtml::_('select.option', $row->id, $row->username.' - '.$row->name);
    }

    // Merge any additional options in the XML definition.
		$options = array_merge(parent::getOptions(), $options);

    return $options;

	}

	protected function getAssocUsers()
	{
		$db = JFactory::getDbo();

		$query = $db->getQuery(true)
	              ->select('a.userid')
	              ->from('`#__core_users_cedis_map` AS a');
		$db->setQuery($query);
		return $db->loadObjectlist();
	}

}
