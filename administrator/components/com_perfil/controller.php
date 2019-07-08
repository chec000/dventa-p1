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

/**
 * Class Pass_recoveryController
 *
 * @since  1.6
 */
class PerfilController extends JControllerLegacy
{

    public function display($cachable = false, $urlparams = false)
    {


        $view = JFactory::getApplication()->input->getCmd('view', 'perfiles');
        JFactory::getApplication()->input->set('view', $view);

        parent::display($cachable, $urlparams);

        return $this;
    }
}