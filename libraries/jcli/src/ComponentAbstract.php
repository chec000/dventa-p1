<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Adteam\Core\Motivale;

/**
 * Description of ComponentAbstract
 *
 * @author dev
 */
use Zend\Soap\Client;

class ComponentAbstract
{
    /**
     *
     * @var type 
     */
    protected  $config;


    /**
     * 
     * @return type
     */
    public function getConfig() 
    {
        return $this->config;
    }

    /**
     * 
     * @param \Motivale\Service\type $config
     */
    public function setConfig(array $config) 
    {
        $this->config = $config;
    }
    
    /**
     * 
     * @param array $array
     * @param type $columnKey
     * @param type $indexKey
     * @return array
     */
    public function array_column(array $array, $columnKey, $indexKey = null)
    {
        $result = array();
        foreach ($array as $subArray) {
            if (!is_array($subArray)) {
                continue;
            } elseif (is_null($indexKey) && array_key_exists($columnKey, $subArray)) {
                $result[] = $subArray[$columnKey];
            } elseif (array_key_exists($indexKey, $subArray)) {
                if (is_null($columnKey)) {
                    $result[$subArray[$indexKey]] = $subArray;
                } elseif (array_key_exists($columnKey, $subArray)) {
                    $result[$subArray[$indexKey]] = $subArray[$columnKey];
                }
            }
        }
        return $result;
    }
    
    /**
     * @return string
     */
    public function getNameFilehash($ext='jpg'){
        return hash('sha1', uniqid(time(),true)).'.'.$ext;
    }   
    
    /**
     * @param $imgUrl
     * @return string
     */
    public function downloadImg($imgUrl)
    {
        $tmp = explode('.',$imgUrl);
        $ext = end($tmp); 
        $newName = $this->getNameFilehash($ext);
        $config = $this->getConfig();
        $file_name =  $config['motivale']['pathimg'].$newName;
        $file_data = @file_get_contents($imgUrl);
        if($file_data!==false){
            @file_put_contents($file_name, $file_data);
        }    
        return $newName;
    }
    
    /**
     * @param $filename
     */
    public function deleteImg($filename){
        $config = $this->getConfig();
        $file = $config['motivale']['pathimg'].$filename;
        if(file_exists($file) && is_file($file)){
            unlink($file);
        }
    }   
    
    /**
     * 
     * @param type $task
     */
    public function queryMotivale($task,$catalogId)
    {
        $config = $this->getConfig();
        if($catalogId>0){
            $options = array(
                'compression' => $config['motivale']['compression'],
                'cache_wsdl' => $config['motivale']['cache_wsdl']);
            $url = $config['motivale']['wsdl']; 
            $client = new Client($url,$options);
            $result = $client->ConsultaCatalogo(array('idcatalogo' => $catalogId));
            $filename = $config['motivale']['pathfilejson'].$task['fileName'];
            file_put_contents($filename, $result->ConsultaCatalogoResult);
        }
    }  
}
