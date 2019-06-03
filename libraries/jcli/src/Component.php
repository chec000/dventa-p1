<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Adteam\Core\Motivale;

use Zend\ServiceManager\ServiceManager;
use Doctrine\ORM\EntityManager;
use Adteam\Core\Motivale\Entity\CoreMotivaleRequest;
use Adteam\Core\Motivale\Entity\CoreMotivale;
use Adteam\Core\Motivale\Entity\CoreConfigs;
use Adteam\Core\Motivale\Entity\CoreProducts;
use Adteam\Core\Motivale\ComponentAbstract;
use Zend\Json\Json;
use Adteam\Core\Motivale\CategoryComponent;
use Adteam\Core\Motivale\Entity\CoreProductsXCategories;

/**
 * Description of Command
 *
 * @author dev
 */
 
class Component extends ComponentAbstract
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
        try{
            $this->client();
        } catch (\Exception $ex) {
            throw new \InvalidArgumentException(
                    $ex->getMessage(),422);   
        }
        
    }
    
    /**
     * 
     */
    public function client()
    {
        $catalogs = $this->setCatalogs();
        foreach ($catalogs as $catalog){
            $task = $this->getFirstQueue();
            if(count($task)>0){
                $this->loadEmpty($task, $catalog);   
            }else{
                $this->checkProcess();
            }            
        }

    }   
    
    /**
     * 
     */
    private function checkProcess()
    {
        $task = $this->getFirstQueue('process');
        if(count($task)>0){
            $resultSet = $this->em->getRepository(CoreMotivale::class)
                    ->hasEmpty();
            if(count($resultSet)<=0){
                //despublica productos
                $this->em->getRepository(CoreProducts::class)->displublish();
                //marca en estatus terminado en motivale request
                $this->setAction($task['id'], 'done');
                //trunca tabla motivale
                $this->trancateMotivale(); 
                //descarga imagenes y actualiza los nombres en la base de datos
                $this->downloadMotivale($task);
                //elimina archivo donde esta el json motivale
                $this->unlinkStorage($task);
            }else{
                // cuando no esta <=0
            }
        }        
    }
    
    /**
     * 
     * @param type $task
     * @throws \InvalidArgumentException
     */
    private function downloadMotivale($task)
    {
        $config = $this->getConfig();
        $fileName = $config['motivale']['pathfilejson'].$task['fileName'];       
        if(file_exists($fileName)){
            $content = Json::decode(file_get_contents($fileName),1);
            $listImages = [];
            foreach ($content as $item){
                $newName = $this->downloadImg($item['Imagen']);
                $listImages[] =['Imagen'=>$newName,'sku'=>$item['Codigo']];
            }
            $this->updateNamesImages($listImages);
        }else{
            throw new \InvalidArgumentException(
                    'Not Found File Storage',422);            
        }        
    } 
    
    /**
     * 
     * @param type $listImages
     */
    private function updateNamesImages($listImages)
    {
        $confing = $this->getConfig();
        $this->em->getRepository(CoreProducts::class)
                ->updateImage($listImages,$confing);
    }        

    /**
     * 
     * @param type $task
     */
    private function unlinkStorage($task)
    {
        $config = $this->getConfig();
        $fileName = $config['motivale']['pathfilejson'].$task['fileName'];
        if(file_exists($fileName)){
            unlink($fileName);
        }
    }        

    /**
     * 
     */
    private function trancateMotivale()
    {
        $this->em->getRepository(CoreMotivale::class)->truncate();
    }        

    /**
     * 
     * @param type $task
     * @param type $catalog
     */
    private function loadEmpty($task, $catalog)
    {
        if($this->isTableEmpty()){
            $this->statusIsTableEmpty($task, $catalog);                
        }
        else
        {
            $this->setAction($task['id'], 'process');
            try{
                $itemsStore = $this->getItemsByStorage($task);
                
                if(count($itemsStore)>0)
                {
                    $itemsPreProcess = $this->getSkus();
                    
                    if(count($itemsPreProcess)>0)
                    {
                        $this->saveProducts($itemsStore, $itemsPreProcess);
                    }                  
                }
            } catch (\Exception $ex) {
                var_dump($ex->getMessage());
            }                    
        }        
    }  

    /**
     * 
     * @param type $task
     * @return type
     */
    private function getItemsByStorage($task)
    {
        $items = [];
        $config = $this->getConfig(); 
        $filename = $config['motivale']['pathfilejson'].$task['fileName'];
        if(file_exists($filename))
        {
            $content = Json::decode(file_get_contents($filename),1);                
            $items = array_merge($items,$content);            
        }
        return $items;
    }
    
    /**
     * 
     * @param type $task
     * @param type $catalogs
     */
    private function statusIsTableEmpty($task,$catalog)
    {
        try{
            $this->setAction($task['id'], 'process');
            $this->queryMotivale($task,$catalog);
            $this->readItems($task); 
            $this->setAction($task['id'], 'new');
        } catch (\Exception $ex) {
            $this->setAction($task['id'], 'error');
            $this->truncateMotivale();
        }        
    }        

    /**
     * 
     * @param type $task
     */
    private function readItems($task)
    {
        $config = $this->getConfig();
        $filename = $config['motivale']['pathfilejson'].$task['fileName'];
        if(file_exists($filename)){
            $content = Json::decode(file_get_contents($filename),1);
            $this->saveSkus($content);
        }        
    }        

    /**
     * Register the SKUs in table
     * @param $results
     */
    private function saveSkus($results)
    {
        $this->em->getRepository(CoreMotivale::class)->save($results);
    }

    /**
     * 
     * @return type
     */
    private function setCatalogs()
    {        
        $config = $this->services->get('config');
        $this->setConfig($config);  
        return $this->getCatalogId();
    }        

    /**
     * 
     * @return type
     */    
    public function getFirstQueue($status='new')
    {
        return $this->em->getRepository(CoreMotivaleRequest::class)
                ->getFirstQueue($status);
    }
    
    /**
     * Check if the table of SKUs is empty
     * @return bool
     */
    public function isTableEmpty()
    {
        return $this->em->getRepository(CoreMotivale::class)->getTotalRows();
    } 
    
    /**
     * 
     * @param type $taskId
     * @param type $action
     */
    private function setAction($taskId,$action)
    {
        $this->em->getRepository(CoreMotivaleRequest::class)
                ->setAction($taskId,$action);
    }
    
    /**
     * 
     * @return type
     */
    private function getCatalogId()
    {
        return $this->em->getRepository(CoreConfigs::class)
                ->getCatalogId();        
    }
    
    /**
     * 
     * @return type
     */
    private function getSkus()
    {
        $config = $this->getConfig();
        return $this->em->getRepository(CoreMotivale::class)->getSkus($config);
    }

    /**
     * 
     * @param type $itemsStore
     * @param type $itemsPreProcess
     */
    private function saveProducts($itemsStore,$itemsPreProcess)
    {   
        foreach ($itemsPreProcess as $index)
        {
            $key = array_search(
                    $index['sku'], $this->array_column($itemsStore, 'Codigo'));
            $this->insertItems($itemsStore[$key]);
            $this->setStatus($index['id'], 'process');
        }     

    } 
    
    /**
     * 
     * @param type $id
     * @param type $status
     */
    private function setStatus($id,$status)
    {
        $this->em->getRepository(CoreMotivale::class)->setStatus($status,$id);        
    }
    
    /**
     * 
     * @param type $items
     */
    private function insertItems($items)
    {
        $data = $this->setItemsInsert($items);
        $productoId = $this->insertOrUpdate($data);
        if(!is_null($data['category'])&&$productoId>0) {
            $this->processCategory($data['category'],$productoId);
        }   
    }

    /**
     * 
     * @param type $items
     * @return type
     */
    private function setItemsInsert($items)
    {
        return array(
            'sku'           => isset($items['Codigo'])?$items['Codigo']:'',
            'title'         => isset($items['NombreArticulo'])?
                               trim($items['NombreArticulo']):'',
            'description'   => isset($items['Descripcion'])?
                               trim($items['Descripcion']):'',
            'fileName'      => isset($items['Imagen'])?$items['Imagen']:'',
            'brand'         => isset($items['Marca'])?trim($items['Marca']):'',
            'realPrice'     => isset($items['Precio'])?$items['Precio']:'',
            'price'         => isset($items['Puntos'])?$items['Puntos']:'',
            'payload'       => serialize($items),
            'enabled'       => 1,
            'editable'      => 0,
            'category'      => isset($items['Categoria'])?
                               $items['Categoria']:null 
        );        
    }        

    /**
     * 
     * @param type $data
     * @return type
     */
    public function insertOrUpdate($data)
    { 
        $productoId = 0;       
        $Table = $this->em->getRepository(CoreProducts::class);
        $resultSet = $Table->getSingleProduct($data['sku']);
        if(count($resultSet)>0){
            $this->deleteImg($resultSet['fileName']);
        }  
        if(count($resultSet)>0){ 
            $this->clearRelation($resultSet['id']);
            $Table->save($data, $resultSet['id']);                          
            $productoId = $resultSet['id'];
        }else{
            $productoId = $Table->save($data);
        }    
        return $productoId;
    } 
    
    private function clearRelation($productId)
    {
        $this->em->getRepository(CoreProductsXCategories::class)
                ->clearRelation($productId);
    }        

    /**
     * 
     */
    private function truncateMotivale()
    {
        $this->em->getRepository(CoreMotivale::class)->truncate();
    }        

    /**
     * 
     * @param type $categoryName
     * @param type $productoId
     */
    private function processCategory($categoryName, $productoId)
    {
        $component = new CategoryComponent($this->services);
        $component->processCategory($categoryName, $productoId);
    }        
}

