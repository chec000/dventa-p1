<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Adteam\Core\Motivale\Repository;

/**
 * Description of CoreProductsRepository
 *
 * @author dev
 */

use Doctrine\ORM\EntityRepository;
use Adteam\Core\Motivale\Entity\CoreProducts;
use Adteam\Core\Motivale\Entity\CoreMotivale;

class CoreProductsRepository extends EntityRepository
{
    /**
     * 
     * @param type $sku
     * @return type
     */
    public function getSingleProduct($sku)
    {
        try{
            return $this
                ->createQueryBuilder('P')
                ->select("P.id,P.sku,P.fileName")
                ->where('P.sku LIKE :sku')
                ->setParameter('sku', $sku)
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
    public function save($data,$id=null)
    {
        $productId = null;
        $CoreProducts = new CoreProducts();
        foreach ($data as $key=>$value){
            if (method_exists($CoreProducts, 'set'.ucfirst($key))) {
                $CoreProducts->{'set'.ucfirst($key)}($value);
            }            
        }

        if(is_null($id)){            
            $this->_em->persist($CoreProducts);
            $this->_em->flush();
            $productId = $CoreProducts->getId();
        }else{
            $productId = $this->update($data, $id);             
        }
        
        return $productId;
    }   
    
    /**
     * 
     */
    public function displublish()
    {
        $resultSet = $this->getDiff();
        foreach ($resultSet as $item)
        {
            $this
                ->createQueryBuilder('U')
                ->update('')
                ->set('U.enabled', 0)
                ->where('U.id = :id')
                ->setParameter('id', $item['id'])
                ->getQuery()
                ->execute();
        }        
    } 
    
    /**
     * 
     * @return type
     */
    public function getDiff(){
       $Dql = 'SELECT p.id FROM '.CoreProducts::class.
              ' p WHERE p.sku NOT IN (SELECT M.sku FROM '.
              CoreMotivale::class.' M)';       
        return $this->_em->createQuery($Dql)->getArrayResult();
    } 
    
    /**
     * 
     * @param type $data
     * @param type $id
     */
    private function update($data,$id)
    {
        $qb = $this->createQueryBuilder('U');
        $qb->update('')
            ->set('U.title', $qb->expr()->literal($data['title']))
            ->set('U.description', $qb->expr()->literal($data['description']))
            ->set('U.fileName', $qb->expr()->literal($data['fileName']))
            ->set('U.brand', $qb->expr()->literal($data['brand']))
            ->set('U.realPrice', $qb->expr()->literal($data['realPrice']))
            ->set('U.price', $qb->expr()->literal($data['price'])) 
            ->set('U.realPrice', $qb->expr()->literal($data['realPrice']))
            ->set('U.payload', $qb->expr()->literal($data['payload']))  
            ->set('U.enabled', $qb->expr()->literal($data['enabled']))
            ->where('U.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->execute();        
    }  
    
    /**
     * 
     * @param type $items
     */
    public function updateImage($items,$config)
    {
        
        foreach ($items as $data){
            $item = $this->getSingleProduct($data['sku']);            
            if(count($item)>0){
                $filenameUnlink =  $config['motivale']['pathfilejson'].
                        $item['fileName'];
                if(file_exists($filenameUnlink)){
                    unlink($filenameUnlink);
                }
                $qb = $this->createQueryBuilder('U');
                $qb->update('')
                    ->set('U.fileName', $qb->expr()->literal($data['Imagen']))          
                    ->where('U.id = :id')
                    ->setParameter('id', $item['id'])
                    ->getQuery()
                    ->execute();           
            }            
        }

    }
}
