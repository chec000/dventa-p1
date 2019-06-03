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

        $this->form  = $this->get('Form');

        if (count($errors = $this->get('Errors')))
        {
            throw new Exception(implode("\n", $errors));
        }


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

}


