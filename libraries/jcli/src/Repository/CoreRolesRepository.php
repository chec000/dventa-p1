<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Adteam\Core\Motivale\Repository;

/**
 * Description of CoreRolesRepository
 *
 * @author dev
 */

use Doctrine\ORM\EntityRepository;

class CoreRolesRepository extends EntityRepository
{
    /**
     * 
     * @return type
     */
    public function fetchAll()
    {
        return $this
            ->createQueryBuilder('R')
            ->select("R.id,R.role")
            ->getQuery()->getArrayResult();        
    }        
}
