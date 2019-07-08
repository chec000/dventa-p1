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
jimport( 'joomla.form.form' );
/**
 * View class for a list of Pass_recovery.
 *
 * @since  1.6
 */
class perfilViewperfil extends JViewLegacy
{
    protected $form;
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
        $this->form  = $this->get('Form');
        $this->params = $this->get('Params');
        $this->addToolbar();
        $jinput = JFactory::getApplication()->input;
        $userId     = $jinput->get('id', 1, 'INT');
        $this->userId=$userId;

        if (count($errors = $this->get('Errors')))
        {
            throw new Exception(implode("\n", $errors));
        }


        parent::display($tpl);
    }
//JToolbarHelper::cancel('mecanica.cancel');

    protected function addToolbar()
    {

        $bar = JToolBar::getInstance('toolbar');
           JToolbarHelper::title(JText::_('COM_PERFIL_COMPONENT_USER'), '');
        JToolbarHelper::preferences('com_perfil');
        JToolbarHelper::back("COM_PERFIL_COMPONENT_BACK");

        //Filtro lateral de búsqueda por estatus
    }

    private function getFiles(){


        $doc = JFactory::getDocument();
        $doc->addScript($this->_getJSSCSSPath('jquery-3.4.1.min.js', 'com_perfil','js'));
        $doc->addScript($this->_getJSSCSSPath('validacion.js', 'com_perfil','js'));
        $doc->addStyleSheet($this->_getJSSCSSPath("perfil.css",'com_perfil','css'));


        $doc->addScript($this->_getJSSCSSPath('sweetalert2.min.js', 'com_perfil','js'));
        $doc->addScript($this->_getJSSCSSPath('bootstrap-select.min.js', 'com_perfil','js'));
        $doc->addStyleSheet($this->_getJSSCSSPath("styles.css",'com_perfil','css'));
        $doc->addStyleSheet($this->_getJSSCSSPath("sweetalert2.min.css",'com_perfil','css'));
        // $doc->addStyleSheet($this->_getJSSCSSPath("bootstrap.min.css",'com_perfil','css'));
        $doc->addStyleSheet($this->_getJSSCSSPath("bootstrap-select.min.css",'com_perfil','css'));

        JText::script('COM_PERFIL_INVALID_FIELD');
        JText::script('COM_PERFIL_TEXT_ERROR_DATOS');
        JText::script('COM_PERFIL_TEXT_ERROR_DATOS_DETALLE');
        JText::script('COM_PERFIL_TEXT_CAPTURE_RESPUESTA');
        JText::script('COM_PERFIL_TEXT_EXITO');
        JText::script('COM_PERFIL_TEXT_ESPERE');
        JText::script('COM_PERFIL_ERROR_VERIFIQUE');
        JText::script('COM_USERS_TERM_COND');
        JText::script('COM_PERFIL_REGISTER_RFC_INVALID_FIELD');
        JText::script('COM_PERFIL_REGITER_INVALID_FIELD');
        JText::script('COM_PERFIL_REGITER_INVALID_NAME_FIELD');
        JText::script('COM_PERFIL_REGITER_INVALID_PASSWORD_REPIT_FIELD');
        JText::script('COM_PERFIL_REGITER_INVALID_PASSWORD_FIELD');
        JText::script('COM_PERFIL_REGITER_INVALID_NAME__FIELD');

        JText::script('COM_PERFIL_REGISTER_CELLPHONE_ERROR');
        JText::script('COM_PERFIL_REGISTER_EMAIL1_ERROR');
        JText::script('COM_PERFIL_REGISTER_LASTNAME2_ERROR');
        JText::script('COM_PERFIL_REGISTER_LASTNAME1_ERROR');
        JText::script('COM_PERFIL_REGISTER_NAME_ERROR');
        JText::script('COM_PERFIL_REGISTER_REFERN_ERROR');

        JText::script('COM_PERFIL_REGISTER_PIN1_ERROR');
        JText::script('COM_PERFIL_REGISTER_PIN2_ERROR');
        JText::script('COM_PERFIL_REGISTER_STREET_ERROR');
        JText::script('COM_PERFIL_REGISTER_EMAIL_LABEL_ERROR');
        JText::script('COM_PERFIL_REGISTER_TELEFONO_LABEL_ERROR');
        JText::script('COM_PERFIL_INVALID_EMAIL_EXIST');



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

}


