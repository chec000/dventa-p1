<?php
return [
    '@class' => 'Gantry\\Component\\Config\\CompiledConfig',
    'timestamp' => 1560963211,
    'checksum' => '5f4ef6e094aa504df0c0ea59187a1bed',
    'files' => [
        'templates/rt_photon/custom/config/37' => [
            'assignments' => [
                'file' => 'templates/rt_photon/custom/config/37/assignments.yaml',
                'modified' => 1519682534
            ],
            'index' => [
                'file' => 'templates/rt_photon/custom/config/37/index.yaml',
                'modified' => 1559771619
            ],
            'layout' => [
                'file' => 'templates/rt_photon/custom/config/37/layout.yaml',
                'modified' => 1559771619
            ],
            'page/head' => [
                'file' => 'templates/rt_photon/custom/config/37/page/head.yaml',
                'modified' => 1560963211
            ],
            'styles' => [
                'file' => 'templates/rt_photon/custom/config/37/styles.yaml',
                'modified' => 1538500846
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
            'name' => '37',
            'timestamp' => 1559771619,
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
                'messages' => [
                    'system-messages-8537' => 'System Messages'
                ],
                'logo' => [
                    'logo-8027' => 'Logo / Image',
                    'logo-6385' => 'Logo',
                    'logo-5738' => 'Logo / Image'
                ],
                'menu' => [
                    'menu-6520' => 'Menu'
                ],
                'module' => [
                    'position-module-4132' => 'Module Instance',
                    'position-module-9931' => 'Module Instance',
                    'position-module-8117' => 'Module Instance'
                ],
                'custom' => [
                    'custom-1368' => 'Custom HTML',
                    'custom-7314' => 'Custom HTML',
                    'custom-7926' => 'Custom HTML',
                    'custom-5329' => 'Custom HTML',
                    'custom-3587' => 'Custom HTML'
                ],
                'spacer' => [
                    'spacer-4502' => 'Spacer'
                ],
                'social' => [
                    'social-5906' => 'Social'
                ],
                'mobile-menu' => [
                    'mobile-menu-8328' => 'Mobile Menu'
                ]
            ],
            'inherit' => [
                'default' => [
                    'top' => 'top',
                    'system-messages-8537' => 'system-messages-9828',
                    'navigation' => 'navigation',
                    'logo-8027' => 'logo-1353',
                    'logo-6385' => 'logo-5992',
                    'menu-6520' => 'menu-4196',
                    'position-module-4132' => 'position-module-1300',
                    'mainBanner' => 'mainBanner',
                    'custom-1368' => 'custom-3367',
                    'copyright' => 'copyright',
                    'logo-5738' => 'logo-3639',
                    'custom-7314' => 'custom-6283',
                    'custom-7926' => 'custom-5507',
                    'custom-5329' => 'custom-7507',
                    'spacer-4502' => 'spacer-2787',
                    'social-5906' => 'social-5421',
                    'custom-3587' => 'custom-9794',
                    'offcanvas' => 'offcanvas',
                    'mobile-menu-8328' => 'mobile-menu-1097'
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
                    
                ],
                '/mainwrap/' => [
                    0 => [
                        0 => 'position-module-9931'
                    ],
                    1 => [
                        0 => 'position-module-8117'
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
                'banner' => [
                    'type' => 'section',
                    'attributes' => [
                        'boxed' => ''
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
            ],
            'content' => [
                'position-module-9931' => [
                    'title' => 'Module Instance',
                    'attributes' => [
                        'module_id' => '103',
                        'key' => 'module-instance'
                    ]
                ],
                'position-module-8117' => [
                    'title' => 'Module Instance',
                    'attributes' => [
                        'module_id' => '117'
                    ]
                ]
            ]
        ],
        'page' => [
            'head' => [
                'atoms' => [
                    0 => [
                        'id' => 'frameworks-8133',
                        'type' => 'frameworks',
                        'title' => 'JavaScript Frameworks',
                        'inherit' => [
                            'outline' => 'default',
                            'atom' => 'frameworks-8133',
                            'include' => [
                                0 => 'attributes'
                            ]
                        ]
                    ],
                    1 => [
                        'id' => 'atomo-Ir-arriba-9744',
                        'type' => 'atomo-Ir-arriba',
                        'title' => 'Ir arriba',
                        'inherit' => [
                            'outline' => 'default',
                            'atom' => 'atomo-Ir-arriba-9744',
                            'include' => [
                                0 => 'attributes'
                            ]
                        ]
                    ],
                    2 => [
                        'id' => 'hover-1375',
                        'type' => 'hover',
                        'title' => 'Hover',
                        'inherit' => [
                            'outline' => 'default',
                            'atom' => 'hover-1375',
                            'include' => [
                                0 => 'attributes'
                            ]
                        ]
                    ],
                    3 => [
                        'id' => 'block-application-6026',
                        'type' => 'block-application',
                        'title' => 'Block Application',
                        'attributes' => [
                            'enabled' => '1'
                        ]
                    ]
                ]
            ]
        ],
        'styles' => [
            'preset' => 'preset1'
        ]
    ]
];
