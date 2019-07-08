<?php
return [
    '@class' => 'Gantry\\Component\\File\\CompiledYamlFile',
    'filename' => 'C:\\xampp\\htdocs\\dventa/templates/rt_photon/custom/config/40/layout.yaml',
    'modified' => 1547757465,
    'data' => [
        'version' => 2,
        'preset' => [
            'image' => 'gantry-admin://images/layouts/default.png',
            'name' => 'adbox_system_content',
            'timestamp' => 1512066350
        ],
        'layout' => [
            'top' => [
                
            ],
            'navigation' => [
                
            ],
            '/mainwrap/' => [
                0 => [
                    0 => 'system-content-2084'
                ]
            ],
            '/optional/' => [
                
            ],
            'mainBanner' => [
                
            ],
            '/footer/' => [
                
            ],
            'copyright' => [
                
            ],
            'offcanvas' => [
                
            ]
        ],
        'structure' => [
            'top' => [
                'type' => 'section',
                'inherit' => [
                    'outline' => 'default',
                    'include' => [
                        0 => 'attributes',
                        1 => 'children'
                    ]
                ]
            ],
            'navigation' => [
                'type' => 'section',
                'inherit' => [
                    'outline' => 'default',
                    'include' => [
                        0 => 'attributes',
                        1 => 'children'
                    ]
                ]
            ],
            'mainwrap' => [
                'type' => 'section',
                'attributes' => [
                    'boxed' => '1',
                    'class' => 'main-content'
                ]
            ],
            'optional' => [
                'type' => 'section',
                'attributes' => [
                    'boxed' => ''
                ]
            ],
            'mainBanner' => [
                'type' => 'section',
                'inherit' => [
                    'outline' => 'default',
                    'include' => [
                        0 => 'attributes',
                        1 => 'children'
                    ]
                ]
            ],
            'footer' => [
                'attributes' => [
                    'boxed' => ''
                ]
            ],
            'copyright' => [
                'type' => 'section',
                'inherit' => [
                    'outline' => 'default',
                    'include' => [
                        0 => 'attributes',
                        1 => 'children'
                    ]
                ]
            ],
            'offcanvas' => [
                'inherit' => [
                    'outline' => 'default',
                    'include' => [
                        0 => 'attributes',
                        1 => 'children'
                    ]
                ]
            ]
        ]
    ]
];
