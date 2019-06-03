<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Adteam\Core\Motivale\Repository;

/**
 * Description of CoreMotivaleRepository
 *
 * @author dev
 */

use Doctrine\ORM\EntityRepository;
use Adteam\Core\Motivale\Entity\CoreMotivale;

class CoreMotivaleRepository extends EntityRepository
{
    /**
     * 
     * @return boolean
     */
    public function getTotalRows()
    {
        $isEmpity = FALSE;
        $result = $this
                ->createQueryBuilder('R')
                ->select("COUNT(R.id) as contador")
                ->getQuery()->getSingleResult();
        if($result['contador']===0){
            $isEmpity = TRUE;
        }    
        return $isEmpity;        
    } 
    
    /**
     * 
     * @param type $config
     */
    public function getSkus($config)
    {
        return $this
                ->createQueryBuilder('R')
                ->select("R.id,R.sku,R.estatus")
                ->where('R.estatus = :estatus')
                ->setParameter('estatus', 'new')
                ->setMaxResults($config['motivale']['limit'])
                ->orderBy('R.id','ASC')
                ->getQuery()->getArrayResult();        
    }  
    
    /**
     * 
     * @param type $status
     * @param type $id
     */
    public function setStatus($status,$id)
    {   
        $qb = $this->createQueryBuilder('U');
        $qb->update('')
            ->set('U.estatus', $qb->expr()->literal($status))
            ->where('U.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->execute(); 
    }   
    
    /**
     * 
     * @return type
     */
    public function hasEmpty()
    {
        return $this
                ->createQueryBuilder('R')
                ->select("R.id")
                ->where('R.estatus = :estatus')
                ->setParameter('estatus', 'new')
                ->setMaxResults(10)
                ->getQuery()->getArrayResult();         
    }
    
    /**
     * 
     */
    public function truncate()
    {
        $sql = "TRUNCATE core_motivale";
        $this->_em->getConnection()->query($sql);        
    }  
    
    /**
     * 
     * @param type $results
     */
    public function save($results)
    {                
        foreach($results as $sku){
            $CoreMotivale = new CoreMotivale();
            $CoreMotivale->setSku($sku['Codigo']);
            $CoreMotivale->setEstatus('new');
            $this->_em->persist($CoreMotivale);
            $this->_em->flush();
        }         
    }        
}
