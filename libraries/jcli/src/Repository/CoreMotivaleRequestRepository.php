<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Adteam\Core\Motivale\Repository;

/**
 * Description of CoreMotivaleRequestRepository
 *
 * @author dev
 */

use Doctrine\ORM\EntityRepository;


class CoreMotivaleRequestRepository extends EntityRepository
{
    /**
     * 
     * @param type $status
     * @return type
     */
    public function getFirstQueue($status='new')
    {
        $queue = [];
        $resultSet = $this
                ->createQueryBuilder('R')
                ->select("R.id,R.requestDate,R.fileName,R.action")
                ->where('R.action = :action')
                ->setParameter('action', $status)
                ->orderBy('R.requestDate','ASC')
                ->getQuery()->getResult(); 
        if(count($resultSet)>0){
            $queue = $resultSet[0];
        }   
        return $queue;
    }
    
    /**
     * 
     * @param type $taskId
     * @param type $action
     */
    public function setAction($taskId,$action)
    {
        $qb = $this->createQueryBuilder('U');
        $qb->update('')
            ->set('U.action', $qb->expr()->literal($action))
            ->where('U.id = :id')
            ->setParameter('id', $taskId)
            ->getQuery()
            ->execute(); 
    }        
}
