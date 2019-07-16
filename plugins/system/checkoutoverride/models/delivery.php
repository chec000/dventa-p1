<?php

defined('_JEXEC') or die;

class CheckoutModelDelivery extends JModelLegacy {

    protected static $cedisTable = '#__core_cedis';
    protected static $cartTable = '#__core_user_cart_items';
    protected static $productTable = 'core_products';
    protected static $ProductxRoleTable = 'core_products_x_roles';
    protected static $CategoryxRoleTable = 'core_product_categories_x_roles';
    protected static $productCategoryTable = 'core_products_x_categories';
    protected static $CategoryTable = 'core_product_categories';

    public static function getCedisList() {
        $results = array();
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);

        $query
                ->select(array('c.id, c.cedis_id, c.names_cedis, c.street, 
            c.ext_number, c.int_number, c.location, c.reference, 
            c.estate, c.city, c.state, c.zip_code, c.telephone, c.extra, c.active'))
                ->from($db->quoteName(self::$cedisTable, 'c'))
                ->where('c.active = 1')
                ->order($db->quoteName('c.names_cedis') . ' ASC');

        $db->setQuery($query);

        $results = $db->loadObjectList();
        return $results;
    }

    public static function getCedis($id) {
        $results = array();
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);

        $query
                ->select(array('c.id, c.cedis_id, c.names_cedis, c.street, 
            c.ext_number, c.int_number, c.location, c.reference, 
            c.estate, c.city, c.state, c.zip_code, c.telephone, c.extra, c.active'))
                ->from($db->quoteName(self::$cedisTable, 'c'))
                ->where('c.id = ' . $db->Quote($id))
                ->where('c.active = 1')
                ->order($db->quoteName('c.names_cedis') . ' ASC');

        $db->setQuery($query);

        $result = $db->loadObject();

        if (is_null($result)) {
            $result = new stdClass();
            $result->id = '';
            $result->cedis_id = '';
            $result->city = '';
            $result->state = '';
            $result->names_cedis = '';
        }

        return $result;
    }

    public static function getCedisMap($userid) {
        $results = array();
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);

        $query
                ->select(array('cedisid'))
                ->from('#__core_users_cedis_map')
                ->where('userid = ' . $db->Quote($userid));

        $db->setQuery($query);

        $result = $db->loadObject();

        if ($result) {
            return $result->cedisid;
        }
        return null;
    }

    public function getConfig($key) {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query
                ->select(array('c.id, c.key, c.value'))
                ->from($db->quoteName('#__core_configs', 'c'))
                ->where('c.key = ' . $db->Quote($key))
                ->order($db->quoteName('c.key') . ' ASC');

        $db->setQuery($query);
        return $db->loadObject();
    }

    public static function getCartItems() {
        $results = array();
        $user = JFactory::getUser()->id;

        if ($user > 0) {
            $db = JFactory::getDbo();
            $query = $db->getQuery(true);

            $query
                    ->select(array('b.id', 'b.title', 'b.sku, a.quantity, 
        b.file_name, b.price, a.quantity*b.price as lineTotal, a.product_id, b.enabled'))
                    ->from($db->quoteName(self::$cartTable, 'a'))
                    ->join('INNER', $db->quoteName(self::$productTable, 'b') . ' ON (' .
                            $db->quoteName('a.product_id') . ' = ' .
                            $db->quoteName('b.id') . ')')
                    ->where('a.user_id = ' . $db->Quote($user))
                    ->order($db->quoteName('b.title') . ' ASC');

            $db->setQuery($query);

            $results = $db->loadObjectList();

            if (!empty($results)) {
                foreach ($results as $product) {
                    $price = self::getRolesPrice($product->product_id, $db);
                    if (!is_null($price)) {
                        $product->price = $price;
                        $product->lineTotal = $product->price * $product->quantity;
                    }
                }
            }

            $total = 0;
            foreach ($results as $item) {
                $total += $item->lineTotal;
            }

            $results['items'] = $results;
            $results['lineTotals'] = $total;
        }

        return $results;
    }

    public static function getRoles() {
        $user = JFactory::getUser();
        $rolesString = "";
        foreach ($user->groups as $group) {
            $rolesString .= $group . ',';
        }
        $rolesString = substr($rolesString, 0, -1);
        $roles['string'] = $rolesString;
        $roles['array'] = $user->groups;
        return $roles;
    }

    public static function getRolesPrice($product_id, $db) {
        $results = null;
        $price = null;
        $roles = self::getRoles();
        foreach ($roles['array'] as $rol) {
            $queryRoles = $db->getQuery(true);
            $queryRoles
                    ->select(array('PXR.id, PXR.rol_id, PXR.product_id, PXR.price'))
                    ->from($db->quoteName(self::$ProductxRoleTable, 'PXR'))
                    ->where('PXR.rol_id = ' . $db->Quote($rol))
                    ->where('PXR.product_id = ' . $db->Quote($product_id));

            $db->setQuery($queryRoles);
            $results = $db->loadObject();
            if (!is_null($results)) {
                $price = $results->price;
            }
        }
        return $price;
    }

    public function getProductTypes() {
        $dineroMovilSku = $this->getConfig('checkout.dineromovil.sku');
        $hasDineroMovil = false;
        $hasMotivale = false;
        if ($dineroMovilSku !== null) {
            $items = $this->getCartItems();
            foreach ($items['items'] as $item) {
                if (trim(strtolower($item->sku)) === trim(strtolower($dineroMovilSku->value))) {
                    $hasDineroMovil = true;
                } else {
                    $hasMotivale = true;
                }
            }
        }
        return [ 
            'hasDineroMovil' => $hasDineroMovil,
            'hasMotivale' => $hasMotivale
        ];
    }

}
