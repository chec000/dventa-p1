<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Adteam\Core\Motivale;

/**
 * Description of CategoryComponent
 *
 * @author dev
 */

use Zend\ServiceManager\ServiceManager;
use Adteam\Core\Motivale\Entity\CoreProductCategories;
use Adteam\Core\Motivale\Entity\CoreRolesXProductsCategories;
use Adteam\Core\Motivale\Entity\CoreProductsXCategories;
use Adteam\Core\Motivale\Entity\CoreRoles;
use Doctrine\ORM\EntityManager;

class CategoryComponent 
{
    /**
     *
     * @var type 
     */
    protected $services;

    /**
     *
     * @var type 
     */
    protected $em;
    
    /**
     * 
     * @param ServiceManager $services
     */
    public function __construct(ServiceManager $services)
    {
        $this->services = $services;
        $this->em = $services->get(EntityManager::class);
    }
    
    /**
     * 
     * @param type $categoryName
     * @param type $productoId
     */
    public function processCategory($categoryName,$productoId)
    {
        $categoryId = 0;
        $category = $this->getCategory($categoryName);
        if(count($category)<=0){
            $categoryId = $this->insertCategory($categoryName);
        }
        else
        {
            $categoryId = $category['id'];
        }   

        $this->productsXcategories($categoryId,$productoId);
    }     
    
    /**
     * 
     * @param type $name
     * @return type
     */
    private function getCategory($name)
    {
        return $this->em->getRepository(CoreProductCategories::class)
                ->getCategory($name);
    }  
    
    /**
     * 
     * @param type $categoryName
     * @return type
     */
    private function insertCategory($categoryName)
    {
        return $this->em->getRepository(CoreProductCategories::class)
                ->insertCategory($categoryName);
    }   
    
    /**
     * 
     * @param type $categoryId
     * @param type $productoId
     */
    private function productsXcategories($categoryId,$productoId)
    {
        $this->em->getRepository(CoreProductsXCategories::class)
                ->save($categoryId,$productoId);        
    } 
    
    /**
     * 
     * @param type $categoryId
     */
    private function insertRolesByCategory($categoryId)
    {
        $table = $this->em
                ->getRepository(CoreRolesXProductsCategories::class);
        $contador = $table->countItems();        
        if(isset($contador['contador'])){        
            if($contador['contador']===0){                
                $roles = $this->em
                        ->getRepository(CoreRoles::class)
                        ->fetchAll();            
                foreach ($roles as $role){
                    $table->save($role['id'],$categoryId);
                }
            }
        }
    }        
}
