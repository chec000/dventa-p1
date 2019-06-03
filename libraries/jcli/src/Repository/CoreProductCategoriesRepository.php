<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Adteam\Core\Motivale\Repository;

/**
 * Description of CoreProductCategoriesRepository
 *
 * @author dev
 */

use Doctrine\ORM\EntityRepository;
use Adteam\Core\Motivale\Entity\CoreProductCategories;

class CoreProductCategoriesRepository extends EntityRepository
{
    /**
     * 
     * @param type $name
     * @return type
     */
    public function getCategory($name)
    {
        $dql = "C.id,C.editable,C.name,C.fileName,C.description,C.sort,"
            . "C.enabled,C.createdAt,C.modifiedAt,C.deletedAt";       
        try{
            $result = $this
                    ->createQueryBuilder('C')
                    ->select($dql)
                    ->where('C.name = :name')
                    ->setParameter('name', $name,\Doctrine\DBAL\Types\Type::STRING)
                    ->getQuery()->getSingleResult();
            return $result;
        } catch (\Exception $ex) {
            return [];
        }      
    } 
    
    /**
     * 
     * @param type $categoryName
     * @return type
     */
    public function insertCategory($categoryName)
    {
        $CoreProductCategories = new CoreProductCategories();
        $CoreProductCategories->setName($categoryName);
        $CoreProductCategories->setEnabled(1);
        $CoreProductCategories->setSort(0);
        $CoreProductCategories->setEditable(0);
        $CoreProductCategories->setFileName('');
        $this->_em->persist($CoreProductCategories);
        $this->_em->flush();
        return $CoreProductCategories->getId();        
    }        
}
