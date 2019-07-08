<?php
return [
    '@class' => 'Gantry\\Component\\File\\CompiledYamlFile',
    'filename' => 'C:\\xampp\\htdocs\\dventa/templates/rt_photon/config/default/page/head.yaml',
    'modified' => 1519682534,
    'data' => [
        'meta' => [
            
        ],
        'head_bottom' => '',
        'atoms' => [
            0 => [
                'type' => 'assets',
                'title' => 'Custom CSS / JS',
                'attributes' => [
                    'enabled' => '1',
                    'css' => [
                        0 => [
                            'location' => 'gantry-assets://css/animate.css',
                            'inline' => '',
                            'extra' => [
                                
                            ],
                            'name' => 'Animate CSS'
                        ]
                    ],
                    'javascript' => [
                        
                    ]
                ]
            ],
            1 => [
                'type' => 'frameworks',
                'title' => 'JavaScript Frameworks',
                'attributes' => [
                    'enabled' => '1',
                    'jquery' => [
                        'enabled' => '1',
                        'ui_core' => '0',
                        'ui_sortable' => '0'
                    ],
                    'bootstrap' => [
                        'enabled' => '0'
                    ],
                    'mootools' => [
                        'enabled' => '1',
                        'more' => '0'
                    ]
                ]
            ]
        ]
    ]
];
