<?php

/**
 * @version    CVS: 1.0.0
 * @package    Com_Pass_recovery
 * @author     Adventa <othon.parra@adventa.mx>
 * @copyright  2017 Adventa
 * @license    Licencia Pública General GNU versión 2 o posterior. Consulte LICENSE.txt
 */
// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.view');
jimport( 'joomla.html.html.list' );
/**
 * View class for a list of Pass_recovery.
 *
 * @since  1.6
 */
class perfilViewperfiles extends JViewLegacy
{
	protected $items;
    protected $filterForm;
	protected $pagination;
	protected $state;
	protected $extra_sidebar;
	/**
	 * Display the view
	 *
	 * @param   string  $tpl  Template name
	 *
	 * @return void
	 *
	 * @throws Exception
	 */
	public function display($tpl = null)
	{
        $app = JFactory::getApplication();
      //  $params = JComponentHelper::getComponents('com_perfil');
    //var_dump($params);
    //die();
      //  $dashboardID = $params->get('dashboardID');

        $doc = JFactory::getDocument();
        $doc->addScript($this->_getJSSCSSPath('jquery-3.4.1.min.js', 'com_perfil','js'));
        $doc->addScript($this->_getJSSCSSPath('perfil.js', 'com_perfil','js'));

        $doc->addStyleSheet($this->_getJSSCSSPath("perfil.css",'com_perfil','css'));
        $this->items = $this->get('Items');
		$this->pagination = $this->get('Pagination');
        //$this->filterForm    = $this->get('FilterForm');
        $this->activeFilters = $this->get('ActiveFilters');
        $this->state = $this->get('State');
        $this->addToolbar();
        $array=array(
            ''=>'Filtrar usuarios por: ',
            'inactivo'=>'Inactivos',
            'activo'=>'Activos'
        );

        $this->extra_sidebar= JHtmlSelect::options($array,'opciones','',2,false);

        JHtmlSidebar::addEntry(
            JText::_('COM_PERFIL_FIELDS'),
            'index.php?option=com_perfil&view=perfil',
            true
        );
        $this->sidebar = JHtmlSidebar::render();

		// Check for errors.
		if (count($errors = $this->get('Errors')))
		{
			throw new Exception(implode("\n", $errors));
		}

		//$this->addToolbar();

        parent::display($tpl);
	}

    public static function _getJSSCSSPath($jsfile, $component,$type) {

        $bPath = 'components/' . $component . '/assets/'.$type.'/' . $jsfile;


        if (file_exists(JPATH_BASE . '/' . $bPath)) {


            return JURI::Root(true) . '/administrator/' . $bPath;
        } else {
            return false;
        }
    }

	/**
	 * Add the page title and toolbar.
	 *
	 * @return void
	 *
	 * @since    1.6
	 */
    protected function addToolbar()
    {

        $state = $this->get('State');

        //Verificar permisos usando el helper
        //($state->get('filter.category_id'));
        $user = JFactory::getUser();

        //Instanciar la toolbar para empezar a añadirle titulos y botones
        $bar = JToolBar::getInstance('toolbar');

        //Titlo de la vista
        JToolbarHelper::title(JText::_('Usuarios'), '');

        $state = $this->get('State');
        JToolbarHelper::preferences('com_perfil');
        //Filtro lateral de búsqueda por estatus
    }


    protected function getSortFields()
    {
        return array(
            'c.name' => JText::_('VIEW_CATEGORIES_GETSORTFIELD_NAME'),
            'c.username' => JText::_('VIEW_CATEGORIES_GETSORTFIELD_USERNAME')

        );
    }

}


