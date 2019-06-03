<?php
return [
    '@class' => 'Gantry\\Component\\File\\CompiledYamlFile',
    'filename' => '/var/www/html/templates/rt_photon/custom/config/35/layout.yaml',
    'modified' => 1547757465,
    'data' => [
        'version' => 2,
        'preset' => [
            'image' => 'gantry-admin://images/layouts/default.png',
            'name' => 'adbox_content',
            'timestamp' => 1510163493
        ],
        'layout' => [
            'top' => [
                
            ],
            'navigation' => [
                
            ],
            '/banner/' => [
                0 => [
                    0 => 'owlcarousel-3083'
                ]
            ],
            '/mainwrap/' => [
                0 => [
                    0 => 'system-content-1307'
                ]
            ],
            '/optional/' => [
                
            ],
            'mainBanner' => [
                
            ],
            'footer' => [
                
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
                        1 => 'block',
                        2 => 'children'
                    ]
                ]
            ],
            'navigation' => [
                'type' => 'section',
                'inherit' => [
                    'outline' => 'default',
                    'include' => [
                        0 => 'attributes',
                        1 => 'block',
                        2 => 'children'
                    ]
                ]
            ],
            'banner' => [
                'type' => 'section',
                'attributes' => [
                    'boxed' => '0',
                    'class' => ''
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
                        1 => 'block',
                        2 => 'children'
                    ]
                ]
            ],
            'footer' => [
                'inherit' => [
                    'outline' => 'default',
                    'include' => [
                        0 => 'attributes',
                        1 => 'block',
                        2 => 'children'
                    ]
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
                        1 => 'block',
                        2 => 'children'
                    ]
                ]
            ]
        ],
        'content' => [
            'owlcarousel-3083' => [
                'title' => 'Owl Carousel',
                'attributes' => [
                    'class' => '',
                    'width' => 'g-owlcarousel-fullwidth',
                    'animateIn' => '',
                    'loop' => '1',
                    'autoplay' => '1',
                    'items' => [
                        0 => [
                            'image' => 'gantry-media://B1.jpg',
                            'icon' => '',
                            'title' => '',
                            'desc' => '',
                            'link' => '',
                            'linktext' => '',
                            'buttontarget' => '_self',
                            'buttonclass' => '',
                            'name' => '¡Escoge el premio!'
                        ],
                        1 => [
                            'image' => 'gantry-media://B2.jpg',
                            'icon' => '',
                            'title' => '',
                            'desc' => '',
                            'link' => '',
                            'linktext' => '',
                            'buttontarget' => '_self',
                            'buttonclass' => '',
                            'name' => '¡Solo ingresa y canjea!'
                        ]
                    ]
                ],
                'block' => [
                    'class' => 'g-bottom-offset'
                ]
            ]
        ]
    ]
];
