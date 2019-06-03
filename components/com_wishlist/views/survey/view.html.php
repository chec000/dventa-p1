<?php
defined('_JEXEC') or die('Restricted access');

class WishlistViewSurvey extends JViewLegacy
{
	function display($tpl = null)
	{
		$this->load_assets();
		$userId = JFactory::getUser()->id;
		if($userId > 0){
			$configs = JModelLegacy::getInstance('Config', 'WishlistModel');
			$this->pmr_name = 
			is_null($configs->getConfig('client.name'))?
			null:$configs->getConfig('client.name')->value;
			$this->checkoutProducts = isset($this->checkoutProducts)?$this->checkoutProducts:null;
		}
		else{
			$this->userId = $userId;
		}
		parent::display();
	}

	public function load_assets()
	{
		$doc = JFactory::getDocument();
		$css = $this->_getCSSPath('com_survey.css', 'com_wishlist');
		$js = $this->_getJSPath('com_survey.js', 'com_wishlist');
		$doc->addScript($js);
		if ($css) {
			$doc->addStyleSheet($css);
		}
		if ($js) {
			$doc->addScript($js);
		}
		$doc->addStyleDeclaration($css);
	}

	public static function _getJSPath($jsfile, $component)
	{
		$bPath = 'components/' . $component . '/assets/js/' . $jsfile;
		if (file_exists(JPATH_BASE . '/' . $bPath)) {
			return JURI::Root(true) . '/' . $bPath;
		} else {
			return false;
		}
	}

	public static function _getCSSPath($cssfile, $component)
	{
		$bPath = 'components/' . $component . '/assets/css/' . $cssfile;
		if (file_exists(JPATH_BASE . '/' . $bPath)) {
			return JURI::Root(true) . '/' . $bPath;
		} else {
			return false;
		}
	}
}