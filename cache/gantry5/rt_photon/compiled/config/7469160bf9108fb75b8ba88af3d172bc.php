<?php
return [
    '@class' => 'Gantry\\Component\\Config\\CompiledConfig',
    'timestamp' => 1538670318,
    'checksum' => '193bb07500d6ef1ab90db694c2be31d0',
    'files' => [
        'templates/rt_photon/custom/config/35' => [
            'assignments' => [
                'file' => 'templates/rt_photon/custom/config/35/assignments.yaml',
                'modified' => 1519682534
            ],
            'index' => [
                'file' => 'templates/rt_photon/custom/config/35/index.yaml',
                'modified' => 1538593598
            ],
            'layout' => [
                'file' => 'templates/rt_photon/custom/config/35/layout.yaml',
                'modified' => 1538593598
            ],
            'styles' => [
                'file' => 'templates/rt_photon/custom/config/35/styles.yaml',
                'modified' => 1538500766
            ]
        ]
    ],
    'data' => [
        'assignments' => [
            'menu' => [
                
            ],
            'style' => [
                
            ]
        ],
        'index' => [
            'name' => 35,
            'timestamp' => 1538593598,
            'version' => 7,
            'preset' => [
                'image' => 'gantry-admin://images/layouts/default.png',
                'name' => 'adbox_content',
                'timestamp' => 1510163493
            ],
            'positions' => [
                
            ],
            'sections' => [
                'top' => 'Top',
                'navigation' => 'Navigation',
                'banner' => 'Banner',
                'mainwrap' => 'Mainwrap',
                'optional' => 'Optional',
                'mainBanner' => 'MainBanner',
                'copyright' => 'Copyright',
                'footer' => 'Footer',
                'offcanvas' => 'Offcanvas'
            ],
            'particles' => [
                'owlcarousel' => [
                    'owlcarousel-3083' => 'Owl Carousel'
                ],
                'content' => [
                    'system-content-1307' => 'Page Content'
                ],
                'messages' => [
                    'system-messages-7913' => 'System Messages'
                ],
                'logo' => [
                    'logo-1635' => 'Logo / Image',
                    'logo-7156' => 'Logo',
                    'logo-7520' => 'Logo / Image'
                ],
                'menu' => [
                    'menu-7225' => 'Menu'
                ],
                'module' => [
                    'position-module-6229' => 'Module Instance'
                ],
                'custom' => [
                    'custom-6673' => 'Custom HTML',
                    'custom-9175' => 'Custom HTML',
                    'custom-4909' => 'Custom HTML',
                    'custom-6118' => 'Custom HTML',
                    'custom-4613' => 'Custom HTML'
                ],
                'spacer' => [
                    'spacer-1608' => 'Spacer'
                ],
                'social' => [
                    'social-2107' => 'Social'
                ],
                'mobile-menu' => [
                    'mobile-menu-7674' => 'Mobile Menu'
                ]
            ],
            'inherit' => [
                'default' => [
                    'top' => 'top',
                    'navigation' => 'navigation',
                    'mainBanner' => 'mainBanner',
                    'footer' => 'footer',
                    'copyright' => 'copyright',
                    'offcanvas' => 'offcanvas',
                    'system-messages-7913' => 'system-messages-9828',
                    'logo-1635' => 'logo-1353',
                    'logo-7156' => 'logo-5992',
                    'menu-7225' => 'menu-4196',
                    'position-module-6229' => 'position-module-1300',
                    'custom-6673' => 'custom-3367',
                    'logo-7520' => 'logo-3639',
                    'custom-9175' => 'custom-6283',
                    'custom-4909' => 'custom-5507',
                    'custom-6118' => 'custom-7507',
                    'spacer-1608' => 'spacer-2787',
                    'social-2107' => 'social-5421',
                    'custom-4613' => 'custom-9794',
                    'mobile-menu-7674' => 'mobile-menu-1097'
                ]
            ]
        ],
        'layout' => [
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
                                'image' => 'gantry-media://banner_mecanica.jpg',
                                'icon' => '',
                                'title' => '',
                                'desc' => '',
                                'link' => '',
                                'linktext' => '',
                                'buttontarget' => '_self',
                                'buttonclass' => '',
                                'name' => 'Recompensa tu esfuerzo'
                            ],
                            1 => [
                                'image' => 'gantry-media://banner_mecanica2.jpg',
                                'icon' => '',
                                'title' => '',
                                'desc' => '',
                                'link' => '',
                                'linktext' => '',
                                'buttontarget' => '_self',
                                'buttonclass' => '',
                                'name' => 'Canjea tus puntos'
                            ]
                        ]
                    ],
                    'block' => [
                        'class' => 'g-bottom-offset'
                    ]
                ]
            ]
        ],
        'styles' => [
            'preset' => 'preset1'
        ]
    ]
];
