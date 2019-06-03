<?php
$path=  realpath((__DIR__).'/../../../../');
$filename = $path.'/configuration.php';
$paramjcli = [
    'user'=>'',
    'pass'=>'',
    'db'=>''
];
if(file_exists($filename)){
    require_once $filename;
    $config = new JConfig();
    $paramjcli = [
        'user'=>$config->user,
        'pass'=>$config->password,
        'db'=>$config->db
    ];
}
return [
    'doctrine' => [
        'connection' => [
            'orm_default' => [
                'driverClass' => \Doctrine\DBAL\Driver\PDOMySql\Driver::class,
                'params' => [
                    'url' => 'mysqli://'.$paramjcli['user'].'@127.0.0.1/'.$paramjcli['db'],
                    'charset' => 'utf8',
                    'password'=>$paramjcli['pass']
                ],
            ],
        ],
        'driver' => [
            'Doctrine_driver' => [
                'class' => \Doctrine\ORM\Mapping\Driver\AnnotationDriver::class,
                'cache' => 'array',
                'paths' => [
                    0 => '/home/dev/public_html/core-api/config/autoload/../../module/Application/src/Entity',
                ],
            ],
            'orm_default' => [
                'drivers' => [
                    'Application\\Entity' => 'Doctrine_driver',
                ],
            ],
        ],
    ]  
];