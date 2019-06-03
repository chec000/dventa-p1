<?php
defined('_JEXEC') or die;

class DealersModelDealers extends JModelList
{

  public function __construct($config = array())
  {

    if (empty($config['filter_fields']))
    {

      $config['filter_fields'] = array(
              'id', 'a.id',
              'cedis_id', 'a.cedis_id',
              'names_cedis', 'a.names_cedis',
              'street', 'a.street',
              'ext_number', 'a.ext_number',
              'int_number', 'a.int_number',
              'location', 'a.location',
              'reference', 'a.reference',
              'city', 'a.city',
              'state', 'a.state',
              'zip_code', 'a.zip_code',
              'telephone', 'a.telephone',
              'active', 'a.active'
              );
    }

    parent::__construct($config);
  }

  protected function getListQuery()
  {

    $db = $this->getDbo();
    $query = $db->getQuery(true);
    $query->select(
            $this->getState(
                    'list.select',
                    'a.id, a.cedis_id,' .
                    'a.names_cedis, a.street,' .
                    'a.ext_number, a.int_number,' .
                    'a.location, a.reference,'.
                    'a.city, a.state,' .
                    'a.zip_code, a.telephone, a.active'
                    )
                );

    $query->from($db->quoteName('#__core_cedis').' AS a');
    $query->where('(a.state IN (0, 1))');

    return $query;
  }

}
