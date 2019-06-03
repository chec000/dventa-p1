<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Adteam\Core\Motivale\Repository;

/**
 * Description of CoreProductsXCategoriesRepository
 *
 * @author dev
 */

use Doctrine\ORM\EntityRepository;
use Adteam\Core\Motivale\Entity\CoreProductsXCategories;
use Adteam\Core\Motivale\Entity\CoreProducts;
use Adteam\Core\Motivale\Entity\CoreProductCategories;

class CoreProductsXCategoriesRepository extends EntityRepository
{
    /**
     * 
     * @param type $categoryId
     * @param type $productoId
     */
    public function save($categoryId,$productoId)
    {        
        $CoreProductsXCategories = new CoreProductsXCategories();
        $product = $this->fetchOne($productoId);
        try {
           $rpro = $this->_em->getReference(CoreProducts::class, $productoId);
           $rcat = $this->_em->getReference(CoreProductCategories::class, $categoryId);
           if(count($product)<=0){
               $CoreProductsXCategories->setProduct($rpro);            
               $CoreProductsXCategories->setCategory($rcat);
               $this->_em->persist($CoreProductsXCategories);
               $this->_em->flush(); 
           }
           else{
               //actualizar
               $this->update($categoryId, $productoId);
           }
                      
        } catch (\Exception $ex) {
            var_dump($ex->getMessage());
        }
      
        
    } 
    
    /**
     * 
     * @param type $id
     * @return type
     */
    public function fetchOne($id)
    {
        try{
            return $this
                ->createQueryBuilder('PxC')
                ->select("PxC.id,P.id as productId,C.id as categoryId")
                ->innerJoin('PxC.product', 'P')
                ->innerJoin('PxC.category', 'C')
                ->where('P.id = :id')
                ->setParameter('id', $id)
                ->getQuery()->getSingleResult();            
        } catch (\Exception $ex) {
            return [];
        }         
    }
    
    /**
     * 
     * @param type $data
     * @param type $id
     */
    private function update($categoryId,$productoId)
    {
        $sql = "UPDATE `core_products_x_categories` SET `category_id`"
                . " = '{$categoryId}' WHERE `core_products_x_categories`."
                . "`product_id` = '{$productoId}'";
       $this->_em->getConnection()->query($sql);
    }  
    
    public function clearRelation($id)
    {
        return $this
                ->createQueryBuilder('u')
                ->delete()
                ->where('u.id = :id')
                ->setParameter('id', $id)
                ->getQuery()->execute();        
    }        
    
}
