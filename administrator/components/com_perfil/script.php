<?php

defined('_JEXEC') or die;

class com_perfilInstallerScript {

    function install($parent) {

    }

    function uninstall($parent) {
        echo '<p>' . JText::_('COM_PERFIL_UNINSTALL_TEXT') . '</p>';
    }

    function update($parent) {
        echo '<p>' . JText::_('COM_PERFIL_UPDATE_TEXT') . '</p>';
    }

    //Se ejecuta antes de que el componente se instale
    function preflight($type, $parent) {

    }

    //Se ejecuta después de que el componente se instala
    function postflight($type, $parent) {

    }

}
