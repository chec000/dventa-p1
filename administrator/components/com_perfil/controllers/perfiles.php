<?php
/**
 * @version    CVS: 1.0.0
 * @package    Com_Pass_recovery
 * @author     Adventa <othon.parra@adventa.mx>
 * @copyright  2017 Adventa
 * @license    Licencia Pública General GNU versión 2 o posterior. Consulte LICENSE.txt
 */

// No direct access.
defined('_JEXEC') or die;

jimport('joomla.application.component.controlleradmin');


/**
 * Passrecoveries list controller class.
 *
 * @since  1.6
 */
class PerfilControllerPerfiles extends JControllerAdmin
{



    public function getModel($name = 'perfiles', $prefix = 'PerfilModel', $config = array('ignore_request' => true))
    {

        return parent::getModel($name, $prefix, $config);
    }

}
