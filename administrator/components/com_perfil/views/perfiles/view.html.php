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
	protected $userId;
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
        $this->getFiles();
        $this->addToolbar();
        $array=array(
            ''=>JText::_('COM_PERFIL_COMPONENT_DATA'),
            'inactivo'=>JText::_('COM_PERFIL_COMPONENT_DATAINCOMPLATE'),
            'activo'=>JText::_('COM_PERFIL_COMPONENT_DATACOMPLATE')
        );

        $this->extra_sidebar= JHtmlSelect::options($array,'opciones','',2,false);
      	if (count($errors = $this->get('Errors')))
		{
			throw new Exception(implode("\n", $errors));
		}

        parent::display($tpl);
	}

	private function getFiles(){
        $doc = JFactory::getDocument();
        $doc->addScript($this->_getJSSCSSPath('jquery-3.4.1.min.js', 'com_perfil','js'));
        $doc->addScript($this->_getJSSCSSPath('perfil.js', 'com_perfil','js'));

        $doc->addStyleSheet($this->_getJSSCSSPath("perfil.css",'com_perfil','css'));
        $this->items = $this->get('Items');
        $this->pagination = $this->get('Pagination');
        $this->activeFilters = $this->get('ActiveFilters');
        $this->state = $this->get('State');

            //
            //
        $doc = JFactory::getDocument();

        $doc->addScript($this->_getJSSCSSPath('sweetalert2.min.js', 'com_perfil','js'));
        $doc->addStyleSheet($this->_getJSSCSSPath("sweetalert2.min.css",'com_perfil','css'));
        // $doc->addStyleSheet($this->_getJSSCSSPath("bootstrap.min.css",'com_perfil','css'));


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
        JToolbarHelper::title(JText::_('COM_PERFIL_COMPONENT_USER'), '');

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


