<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_catalog
 *
 * @copyright   Copyright (C) 2005 - 2017 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

class CatalogModelProductsm extends JModelLegacy
{
    protected $productsTable = 'core_products';
    protected $productsXCategoriesTable = 'core_products_x_categories';
    protected $stockTable = '#__core_products_stock';
    protected $likeTable = '#__core_user_products_likes';
    protected $productPriceTable = 'core_products_x_roles';

    public function saveProduct($params){
        $product = $this->getProduct($params['id'], 'id');
        if (!isset($product->id)) {
            return $this->createProduct($params);
        }
        else{
            return $this->updateProduct($params);
        }
    }

    public function saveCategory($params){
        $category = $this->getCategory($params['id']);
        if (!is_null($category)) {
            return $this->updateCategory($params);
        }
        else{
            return $this->createCategory($params);
        }
    }

    public function updateProduct($params){
        $db = $this->getDbo();
        $query = $db->getQuery(true);

        $fields = array(
            $db->quoteName('sku') . ' = ' . $db->quote($params['sku']),
            $db->quoteName('title') . ' = ' . $db->quote($params['title']),
            $db->quoteName('description') . ' = ' . $db->quote($params['description']),
            $db->quoteName('brand') . ' = ' . $db->quote($params['brand']),
            $db->quoteName('file_name') . ' = ' . $db->quote($params['file_name']),
            $db->quoteName('real_price') . ' = ' . $db->quote($params['real_price']),
            $db->quoteName('price') . ' = ' . $db->quote($params['price']),
            $db->quoteName('payload') . ' = ' . $db->quote($params['payload']),
            $db->quoteName('enabled') . ' = ' . $db->quote($params['enabled']),
            $db->quoteName('editable') . ' = ' . $db->quote($params['editable'])
        );

        $conditions = array(
            $db->quoteName('id') . ' = ' . $db->quote($params['id'])
        );

        $query->update($db->quoteName($this->productsTable))
        ->set($fields)->where($conditions);
        $db->setQuery($query);

        $result = $db->execute();
        $this->saveCategory($params);
        return $result;
    }

    public function updateCategory($params){
        $db = $this->getDbo();
        $query = $db->getQuery(true);

        $fields = array(
            $db->quoteName('category_id') . ' = ' . $db->quote($params['category_id'])
        );

        $conditions = array(
            $db->quoteName('product_id') . ' = ' . $db->quote($params['id'])
        );

        $query->update($db->quoteName($this->productsXCategoriesTable))
        ->set($fields)->where($conditions);
        $db->setQuery($query);

        $result = $db->execute();
        return $result;
    }

    public function createProduct($params)
    {
        $product = $this->getProduct($params['sku'], 'sku');
        if (!isset($product->id)) {
            $db = $this->getDbo();
            $product = new stdClass();
            $product->sku = $params['sku'];
            $product->title = $params['title'];
            $product->description = $params['description'];
            $product->brand = $params['brand'];
            $product->file_name = $params['file_name'];
            $product->real_price = $params['real_price'];
            $product->price = $params['price'];
            $product->payload = $params['payload'];
            $product->enabled = $params['enabled'];
            $product->editable = $params['editable'];
            $db->insertObject($this->productsTable, $product);
            $id = $db->insertid();
            $params['id'] = $id;
            $this->saveCategory($params);
            return $id;
        }
    }

    public function createCategory($params)
    {
        $category = $this->getCategory($params['id']);
        if (is_null($category)) {
            $db = $this->getDbo();
            $category = new stdClass();
            $category->category_id = $params['category_id'];
            $category->product_id = $params['id'];
            $db->insertObject($this->productsXCategoriesTable, $category);
            return $db->insertid();
        }
    }

    public function getProduct($value, $key){
        $results = array();
        $db = $this->getDbo();
        $query = $db->getQuery(true);

        $query
        ->select(array('U.id, U.sku, U.title, U.description,'.
            'U.brand, U.file_name, U.price, U.real_price, U.payload'))
        ->from($db->quoteName($this->productsTable, 'U'))
        ->where('U.' . $key . ' = ' . $db->Quote($value));

        $db->setQuery($query);
        $results = $db->loadObject();
        return $results;
    }

    public function getCategory($product_id)
    {
        $results = array();
        $db = $this->getDbo();
        $query = $db->getQuery(true);

        $query
        ->select(array('U.id, U.product_id, U.category_id'))
        ->from($db->quoteName($this->productsXCategoriesTable, 'U'))
        ->where('U.product_id' . ' = ' . $db->Quote($product_id));

        $db->setQuery($query);
        $results = $db->loadObject();
        return isset($results->category_id)?$results->category_id:null;
    }

    public function deleteProduct($id)
    {
        $this->deleteCategory($id);
        $this->deleteStock($id);
        $this->deleteLike($id);
        $this->deletePrice($id);

        $db = $this->getDbo();
        $query = $db->getQuery(true);

        $conditions = array(
            $db->quoteName('id') . ' = ' . $db->quote($id)
        );

        $query->delete($db->quoteName($this->productsTable));
        $query->where($conditions);

        $db->setQuery($query);
        $result = $db->execute();
    }

    public function deleteCategory($product_id)
    {
        $db = $this->getDbo();
        $query = $db->getQuery(true);

        $conditions = array(
            $db->quoteName('product_id') . ' = ' . $db->quote($product_id)
        );

        $query->delete($db->quoteName($this->productsXCategoriesTable));
        $query->where($conditions);

        $db->setQuery($query);

        $result = $db->execute();
    }

    public function deleteStock($product_id)
    {
        $db = $this->getDbo();
        $query = $db->getQuery(true);

        $conditions = array(
            $db->quoteName('product_id') . ' = ' . $db->quote($product_id)
        );

        $query->delete($db->quoteName($this->stockTable));
        $query->where($conditions);

        $db->setQuery($query);

        $result = $db->execute();
    }

    public function deleteLike($product_id)
    {
        $db = $this->getDbo();
        $query = $db->getQuery(true);

        $conditions = array(
            $db->quoteName('product_id') . ' = ' . $db->quote($product_id)
        );

        $query->delete($db->quoteName($this->likeTable));
        $query->where($conditions);

        $db->setQuery($query);

        $result = $db->execute();
    }

    public function deletePrice($product_id)
    {
        $db = $this->getDbo();
        $query = $db->getQuery(true);

        $conditions = array(
            $db->quoteName('product_id') . ' = ' . $db->quote($product_id)
        );

        $query->delete($db->quoteName($this->productPriceTable));
        $query->where($conditions);

        $db->setQuery($query);

        $result = $db->execute();
    }
}