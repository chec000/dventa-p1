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
 * Pass_recovery helper.
 *
 * @since  1.6
 */
class PerfilHelper
{

    /**
     * Gets a list of the actions that can be performed.
     *
     * @return    JObject
     *
     * @since    1.6
     */
    public static function getActions()
    {
        $user   = JFactory::getUser();
        $result = new JObject;

        $assetName = 'com_pass_recovery';

        $actions = array(
            'core.admin', 'core.manage', 'core.create', 'core.edit', 'core.edit.own', 'core.edit.state', 'core.delete'
        );

        foreach ($actions as $action)
        {
            $result->set($action, $user->authorise($action, $assetName));
        }

        return $result;
    }
}

