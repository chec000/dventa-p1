<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Adteam\Core\Motivale\Repository;

/**
 * Description of CoreRolesXProductsCategoriesRepository
 *
 * @author dev
 */

use Doctrine\ORM\EntityRepository;
use Adteam\Core\Motivale\Entity\CoreRoles;
use Adteam\Core\Motivale\Entity\CoreProductCategories;
use Adteam\Core\Motivale\Entity\CoreRolesXProductsCategories;

class CoreRolesXProductsCategoriesRepository extends EntityRepository
{
    /**
     * 
     * @param type $id
     * @return type
     */
    public function countItems()
    {
        try{
            return $this
                ->createQueryBuilder('PxC')
                ->select("COUNT(PxC.id) as contador")
                ->getQuery()->getSingleResult();            
        } catch (Exception $ex) {
            return [];
        }         
    } 
    
    /**
     * 
     * @param type $roleId
     * @param type $categoryId
     */
    public function save($roleId,$categoryId)
    {
        $rrol = $this->_em->getReference(CoreRoles::class, $roleId);
        $rcat = $this->_em->getReference(CoreProductCategories::class, $categoryId);        
        $CoreRolesXProductsCategories = new CoreRolesXProductsCategories();
        $CoreRolesXProductsCategories->setRole($rrol);
        $CoreRolesXProductsCategories->setCategory($rcat);
        $this->_em->persist($CoreRolesXProductsCategories);
        $this->_em->flush(); 
    }        
}
