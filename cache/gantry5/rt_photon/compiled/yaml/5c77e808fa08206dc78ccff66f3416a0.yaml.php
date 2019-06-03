<?php
return [
    '@class' => 'Gantry\\Component\\File\\CompiledYamlFile',
    'filename' => '/var/www/html/templates/rt_photon/custom/config/38/layout.yaml',
    'modified' => 1547757463,
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
                
            ],
            '/mainwrap/' => [
                0 => [
                    0 => 'custom-6274'
                ]
            ],
            '/optional/' => [
                0 => [
                    0 => 'popupgrid-8660'
                ]
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
                    'boxed' => '1',
                    'class' => ''
                ]
            ],
            'mainwrap' => [
                'type' => 'section',
                'attributes' => [
                    'boxed' => '1',
                    'class' => 'main-content no-margin-bottom gm-title-line'
                ]
            ],
            'optional' => [
                'type' => 'section',
                'attributes' => [
                    'boxed' => '1',
                    'class' => 'main-content'
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
            'custom-6274' => [
                'title' => 'Custom HTML',
                'attributes' => [
                    'html' => '<div id="header_promo">
<h2>Comunicados</h2>
</div>'
                ],
                'block' => [
                    'variations' => 'center nopaddingall'
                ]
            ],
            'popupgrid-8660' => [
                'title' => 'Popup Grid',
                'attributes' => [
                    'items' => [
                        0 => [
                            'img' => 'gantry-media://boletin1.jpg',
                            'width' => '393px',
                            'datasize' => '371x223',
                            'overlay' => 'g-overlay-enable',
                            'previewicon' => '',
                            'tag' => 'Productos',
                            'desc' => '',
                            'animations' => 'g-zoom',
                            'buttontext' => '',
                            'buttonlink' => '',
                            'buttontarget' => '_self',
                            'buttonclass' => '',
                            'title' => 'URREA te premia'
                        ],
                        1 => [
                            'img' => 'gantry-media://boletin2.jpg',
                            'width' => '370px',
                            'datasize' => '170x200',
                            'overlay' => 'g-overlay-enable',
                            'previewicon' => '',
                            'tag' => 'Productos',
                            'desc' => '',
                            'animations' => 'g-zoom',
                            'buttontext' => '',
                            'buttonlink' => '',
                            'buttontarget' => '_self',
                            'buttonclass' => '',
                            'title' => 'Aviso importante'
                        ]
                    ]
                ]
            ]
        ]
    ]
];
