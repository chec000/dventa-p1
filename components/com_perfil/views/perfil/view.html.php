<?php

defined('_JEXEC') or die;

// Nomenclatura de la clase Nombre del componente + View + Nombre de la vista
class PerfilViewPerfil extends JViewLegacy {

    protected $form;
    protected $params;


    public function display($tpl = null) {

        $this->addResources();
        $this->form = $this->get('Form');
       
        $this->params = $this->get('Params');
        
        if (count($errors = $this->get('Errors'))) {
            JError::raiseError(500, implode("\n", $errors));
            return false;
        }
        parent::display($tpl);
    }


    private function addResources(){
        $doc = JFactory::getDocument();
        JHtml::_('jquery.framework');
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
   //validaciones
        JText::script('COM_PERFIL_REGISTER_NAME_ERROR');
        JText::script('COM_PERFIL_REGISTER_LASTNAME1_ERROR');
        JText::script('COM_PERFIL_REGISTER_LASTNAME2_ERROR');
        JText::script('COM_PERFIL_REGISTER_EMAIL1_ERROR');
        JText::script('COM_PERFIL_REGISTER_CELLPHONE_ERROR');
        JText::script('COM_PERFIL_REGISTER_REFERN_ERROR');
        JText::script('COM_PERFIL_REGISTER_PIN1_ERROR');
        JText::script('COM_PERFIL_REGISTER_PIN2_ERROR');
        JText::script('COM_PERFIL_REGISTER_STREET_ERROR');
        JText::script('COM_PERFIL_REGISTER_EMAIL_LABEL_ERROR');
        JText::script('COM_PERFIL_REGISTER_TELEFONO_LABEL_ERROR');
        JText::script('COM_PERFIL_INVALID_EMAIL_EXIST');
        JText::script('COM_PERFIL_INVALID_DATA_TITLE');
        JText::script('COM_PERFIL_INVALID_DATA');
        JText::script('COM_PERFIL_SELECT_OPTION');        
JText::script('COM_PERFIL_TEXT_SAVE_FAIL');        




        $doc->addScript($this->_getJSSCSSPath('validacion.js', 'com_perfil','js'));
        $doc->addScript($this->_getJSSCSSPath('sweetalert2.min.js', 'com_perfil','js'));
        $doc->addScript($this->_getJSSCSSPath('bootstrap-select.min.js', 'com_perfil','js'));
        $doc->addStyleSheet($this->_getJSSCSSPath("styles.css",'com_perfil','css'));
        $doc->addStyleSheet($this->_getJSSCSSPath("sweetalert2.min.css",'com_perfil','css'));
        $doc->addStyleSheet($this->_getJSSCSSPath("bootstrap.min.css",'com_perfil','css'));
        $doc->addStyleSheet($this->_getJSSCSSPath("bootstrap-select.min.css",'com_perfil','css'));

    }

    public static function _getJSSCSSPath($jsfile, $component,$type) {

        $bPath = 'components/' . $component . '/assets/'.$type.'/' . $jsfile;
        if (file_exists(JPATH_BASE . '/' . $bPath)) {
            return JURI::Root(true) . '/' . $bPath.'?'.time();
        } else {
            return false;
        }
    }

}
