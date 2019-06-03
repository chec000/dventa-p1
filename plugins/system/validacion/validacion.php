<?php

/**
 * @copyright	Copyright (c) 2018 adventa.mx. All rights reserved.
 * @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */
// no direct access
defined('_JEXEC') or die;

jimport('joomla.plugin.plugin');

/**
 * Content - Validacion Plugin
 *
 * @package		Joomla.Plugin
 * @subpakage	adventa.mx.Validacion
 */
class plgSystemValidacion extends JPlugin {

    /**
     * Constructor.
     *
     * @param 	$subject
     * @param	array $config
     */
    public function __construct(&$subject, $config = array()) {
        parent::__construct($subject, $config);
    }

    public function onAfterRender() {
        $app = JFactory::getApplication();
        if ($app->isAdmin()) {
            return;
        }
        if ($app->input->get('option', '') == 'com_perfil') {
            return;
        }

       // if ($app->input->get('option', '') == 'com_perfil') {
            // return;
            $user = JFactory::getUser();

            if ((int) $user->id > 0) {
                $db = JFactory::getDbo();
                $query = $db->getQuery(true);

                $query->select(
                    $db->quoteName('u.complete_data'));
                $query->from($db->quoteName('#__core_user_info', 'u'));
                $query->where('u.user_id = ' . $user->id);

                $db->setQuery($query);
                $result = $db->loadObject();

                if (!$result || $result->complete_data != '1') {
                    return $app->redirect(\Joomla\CMS\Router\Route::_('index.php?option=com_perfil&view=perfiles'));
                }
            }else{
                return $app->redirect(\Joomla\CMS\Router\Route::_('index.php?option=com_users&view=profile&layout=edit'));
            }

     //   }
    }

}
