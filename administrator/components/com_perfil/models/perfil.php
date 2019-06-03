<?php
/**
 * @version    1.0.0
 * @package    com_catalog
 * @author     Zitdev <>
 * @copyright  Zitdev (C) 2017. All rights reserved.
 * @license
 */

// No direct access.
defined('_JEXEC') or die;

/**
 *
 *
 * @since  1.6
 */
class PerfilModelPerfil extends JModelAdmin
{
    /**
     * @var      string    The prefix to use with controller messages.
     * @since    1.6
     */
    protected $text_prefix = 'com_perfil';

    /**
     * @var   	string  	Alias to manage history control
     * @since   3.2
     */
    public $typeAlias = 'com_catalog.cproduct';

    /**
     * @var null  Item data
     * @since  1.6
     */
    protected $item = null;

    /**
     * Returns a reference to the a Table object, always creating it.
     *
     * @param   string  $type    The table type to instantiate
     * @param   string  $prefix  A prefix for the table class name. Optional.
     * @param   array   $config  Configuration array for model. Optional.
     *
     * @return    JTable    A database object
     *
     * @since    1.6
     */
    public function getTable($type = 'Cproduct', $prefix = 'CatalogTable', $config = array())
    {
        return JTable::getInstance($type, $prefix, $config);
    }

    /**
     * Method to get the record form.
     *
     * @param   array    $data      An optional array of data for the form to interogate.
     * @param   boolean  $loadData  True if the form is to load its own data (default case), false if not.
     *
     * @return  JForm  A JForm object on success, false on failure
     *
     * @since    1.6
     */
    public function getForm($data = array(), $loadData = true)
    {
        // Initialise variables.

        $form = $this->loadForm('com_perfil.perfil', 'perfil',array('control' => 'jform','load_data' => $loadData)/* $options = array('control' => 'jform')*/);
        if (empty($form)) {
            return false;
        }

        return $form;
    }




    /**
     * Method to get the data that should be injected in the form.
     *
     * @return   mixed  The data for the form.
     *
     * @since    1.6
     */

    /**
     * Method to get a single record.
     *
     * @param   integer  $pk  The id of the primary key.
     *
     * @return  mixed    Object on success, false on failure.
     *
     * @since    1.6
     */



    public function getItem($pk = null)
    {
        if ($item = parent::getItem($pk))
        {

        }

        return $item;
    }

    /**
     *
     *
     * @param   array  &$pks  An array of primary key IDs.
     *
     * @return  boolean  True if successful.
     *
     * @throws  Exception
     */


    /**
     * Prepare and sanitise the table prior to saving.
     *
     * @param   JTable  $table  Table Object
     *
     * @return void
     *
     * @since    1.6
     */

}