<?php
return [
    '@class' => 'Gantry\\Component\\File\\CompiledYamlFile',
    'filename' => '/var/www/html/templates/rt_photon/custom/config/_error/layout.yaml',
    'modified' => 1547757465,
    'data' => [
        'version' => 2,
        'preset' => [
            'image' => 'gantry-admin://images/layouts/default.png',
            'name' => '_error',
            'timestamp' => 1509649909
        ],
        'layout' => [
            '/top/' => [
                0 => [
                    0 => 'system-messages-9828'
                ]
            ],
            '/navigation/' => [
                0 => [
                    0 => 'logo-5992 20',
                    1 => 'menu-4196 60',
                    2 => 'social-7220 20'
                ]
            ],
            '/slideshow/' => [
                
            ],
            '/header/' => [
                0 => [
                    0 => 'simplecontent-7604'
                ]
            ],
            '/above/' => [
                
            ],
            '/showcase/' => [
                0 => [
                    0 => 'system-content-6444'
                ]
            ],
            '/utility/' => [
                
            ],
            '/feature/' => [
                
            ],
            '/container-4448/' => [
                0 => [
                    0 => [
                        'sidebar 20' => [
                            
                        ]
                    ],
                    1 => [
                        'mainbar 60' => [
                            
                        ]
                    ],
                    2 => [
                        'aside 20' => [
                            
                        ]
                    ]
                ]
            ],
            '/expanded/' => [
                
            ],
            '/extension/' => [
                0 => [
                    0 => 'position-position-9401'
                ]
            ],
            '/bottom/' => [
                
            ],
            '/footer/' => [
                
            ],
            'copyright' => [
                
            ],
            'offcanvas' => [
                0 => [
                    0 => 'mobile-menu-7951'
                ]
            ]
        ],
        'structure' => [
            'top' => [
                'type' => 'section',
                'attributes' => [
                    'boxed' => '0'
                ]
            ],
            'navigation' => [
                'type' => 'section',
                'attributes' => [
                    'boxed' => '0',
                    'class' => 'nav-large-offset'
                ]
            ],
            'slideshow' => [
                'type' => 'section',
                'attributes' => [
                    'boxed' => '2',
                    'class' => ''
                ]
            ],
            'header' => [
                'attributes' => [
                    'boxed' => '1',
                    'class' => ''
                ]
            ],
            'above' => [
                'type' => 'section',
                'attributes' => [
                    'boxed' => '1',
                    'class' => ''
                ]
            ],
            'showcase' => [
                'type' => 'section',
                'attributes' => [
                    'boxed' => '1',
                    'class' => ''
                ]
            ],
            'utility' => [
                'type' => 'section',
                'attributes' => [
                    'boxed' => '1',
                    'class' => ''
                ]
            ],
            'feature' => [
                'type' => 'section',
                'attributes' => [
                    'boxed' => '1',
                    'class' => ''
                ]
            ],
            'sidebar' => [
                'type' => 'section',
                'block' => [
                    'class' => 'equal-height'
                ]
            ],
            'mainbar' => [
                'type' => 'section',
                'block' => [
                    'class' => 'equal-height'
                ]
            ],
            'aside' => [
                'block' => [
                    'class' => 'equal-height'
                ]
            ],
            'container-4448' => [
                'attributes' => [
                    'boxed' => '1',
                    'class' => '',
                    'extra' => [
                        
                    ]
                ]
            ],
            'expanded' => [
                'type' => 'section',
                'attributes' => [
                    'boxed' => '1',
                    'class' => ''
                ]
            ],
            'extension' => [
                'type' => 'section',
                'attributes' => [
                    'boxed' => '1',
                    'class' => ''
                ]
            ],
            'bottom' => [
                'type' => 'section',
                'attributes' => [
                    'boxed' => '0',
                    'class' => ''
                ]
            ],
            'footer' => [
                'attributes' => [
                    'boxed' => '0',
                    'class' => ''
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
            ]
        ],
        'content' => [
            'social-7220' => [
                'attributes' => [
                    'css' => [
                        'class' => 'align-right'
                    ]
                ],
                'block' => [
                    'class' => 'hidden-phone'
                ]
            ],
            'simplecontent-7604' => [
                'title' => 'We are sorry!',
                'attributes' => [
                    'items' => [
                        0 => [
                            'layout' => 'header',
                            'created_date' => '',
                            'content_title' => '<span class="fa fa-frown-o"></span> Ups!',
                            'author' => '',
                            'leading_content' => 'La sección a la que intentas ingresar no existe.',
                            'main_content' => '',
                            'readmore_label' => '',
                            'readmore_link' => '',
                            'readmore_class' => '',
                            'readmore_target' => '_self',
                            'title' => 'Ups!'
                        ]
                    ]
                ],
                'block' => [
                    'variations' => 'center'
                ]
            ],
            'system-content-6444' => [
                'block' => [
                    'class' => 'g-error',
                    'variations' => 'center'
                ]
            ],
            'position-position-9401' => [
                'title' => 'Module Position',
                'attributes' => [
                    'key' => 'extension-a'
                ],
                'block' => [
                    'class' => 'g-compact'
                ]
            ],
            'mobile-menu-7951' => [
                'title' => 'Mobile Menu'
            ]
        ]
    ]
];
