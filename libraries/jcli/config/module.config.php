<?php

$path=  realpath((__DIR__).'/../').'/src/';
$pathdata=realpath((__DIR__).'/../../../images');

if(!file_exists($pathdata.'/productos')){
    
    mkdir($pathdata.'/productos');
}

return [
    //
    // Configuraciones adaptador PDO con doctrine
    //
    'doctrine' => [
        'connection' => [
            'orm_default' => [
                'driverClass' => \Doctrine\DBAL\Driver\PDOMySql\Driver::class,
                'params' => [
                    'charset' => 'utf8',
                ],
            ],
        ],
        'driver' => [
            'Doctrine\Driver\Adteam\Core\Motivale' => [
                'class' => \Doctrine\ORM\Mapping\Driver\AnnotationDriver::class,
                'cache' => 'array',
                'paths' => [
                    0 => $path.'/Entity',
                ],
            ],
            'orm_default' => [
                'drivers' => [
                'Adteam\\Core\\Motivale' => 'Doctrine\Driver\Adteam\Core\Motivale',
                ],
            ],
        ],
    ] ,
    //
    // Configuraciones cliente motivale
    //    
    'motivale'=>[
        'pathfilejson'=>$pathdata.'/productos/',
        'pathimg'=>$pathdata.'/productos/',
        'wsdl'=>'http://catalogo.adventa-bs.com/services/WebService.asmx?wsdl',
        'cache_wsdl'=>0,
        'compression'=>SOAP_COMPRESSION_ACCEPT,
        'limit'=>10000         
    ]
];
