<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Adteam\Core\Motivale\Repository;

/**
 * Description of CoreConfigsRepository
 *
 * @author dev
 */
use Doctrine\ORM\EntityRepository;

class CoreConfigsRepository extends EntityRepository
{
    /**
     * 
     * @return type
     * @throws \InvalidArgumentException
     */
    public function getCatalogId()
    {
        try{
            $result = $this
                    ->createQueryBuilder('C')
                    ->select("C.id,C.key,C.value")
                    ->where('C.key = :key')
                    ->setParameter('key', 'catalog.motivale.id')
                    ->getQuery()->getSingleResult();
            return $this->explodeKey($result['value']);
        } catch (\Exception $ex) {
            throw new \InvalidArgumentException(
                    'key catalog.motivale.id no existe',422);
        }
    }    

    /**
     * 
     * @param type $value
     * @return type
     */
    private function explodeKey($value)
    {
        $catalogs = [];
        $explode = explode(',', $value);
        foreach ($explode as $item){
            $catalog = trim($item);
            $catalogs[]= (int)$catalog;
        }
        return $catalogs;
    }        
}
