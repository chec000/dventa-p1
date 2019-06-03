<?php
/**
 * @version    1.0.0
 * @package    com_catalog
 * @author     Zitdev <>
 * @copyright  Zitdev (C) 2017. All rights reserved.
 * @license    
 */

// No direct access
defined('_JEXEC') or die;

/**
 * 
 *
 * @since  1.6
 */
class CatalogControllerCproduct extends JControllerForm
{
	/**
	 * Constructor
	 *
	 * @throws Exception
	 */
	public function __construct()
	{
		$this->view_list = 'cproducts';
		parent::__construct();
	}

	public function delete()
	{
		$cid = JRequest::getVar('cid',  0, '');
		$model = $this->getModel('Cproduct');
		$status = $model->delete($cid);
		if ($status) {
			$this->setMessage(JText::plural('COM_CATALOG_N_ITEMS_DELETED', count($cid)));
		}
		$this->setRedirect(JRoute::_(
			'index.php?option=com_catalog&view=cproducts', false));
	} 
}
