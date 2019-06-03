<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_wishlist
 *
 * @copyright   Copyright (C) 2005 - 2017 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

class WishlistModelProduct extends JModelLegacy
{
    protected $productsTable = 'core_products';
    protected $ProductxRoleTable = 'core_products_x_roles';

    public function getRoles($user_id){
        $user = JFactory::getUser($user_id);
        $rolesString = "";
        foreach ($user->groups as $group) {
            $rolesString .= $group . ',';
        }
        $rolesString = substr($rolesString, 0, -1);
        $roles['string'] = $rolesString;
        $roles['array'] = $user->groups;
        return $roles;
    }

    public function getRolesPrice($params, $db){
        $results = null;
        $price = null;
        $roles = $this->getRoles($params['user']);
        foreach ($roles['array'] as $rol) {
            $queryRoles = $db->getQuery(true);
            $queryRoles
            ->select(array('PXR.id, PXR.rol_id, PXR.product_id, PXR.price'))
            ->from($db->quoteName($this->ProductxRoleTable, 'PXR'))
            ->where('PXR.rol_id = ' . $db->Quote($rol))
            ->where('PXR.product_id = ' . $db->Quote($params['product']));

            $db->setQuery($queryRoles);
            $results = $db->loadObject();
            if (!is_null($results)) {
                $price = $results->price;
            }
        }
        return $price;
    }

    public function getProduct($params){
        $results = array();
        $user = JFactory::getUser()->id;
        if ($user > 0) {
            $db = $this->getDbo();
            $query = $db->getQuery(true);

            $query
            ->select(array('U.id, U.sku, U.title, U.description,'.
                'U.brand, U.file_name, U.price, U.real_price, U.payload'))
            ->from($db->quoteName($this->productsTable, 'U'))
            ->where('U.id = ' . $db->Quote($params['product']));

            $db->setQuery($query);
            $results = $db->loadObject();
            if (!is_null($results)) {
                $price = $this->getRolesPrice($params ,$db);
                if (!is_null($price))
                    $results->price = $price;
            }
        }
        return $results;
    }

}