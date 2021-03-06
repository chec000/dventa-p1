<?php
return [
    '@class' => 'Gantry\\Component\\File\\CompiledYamlFile',
    'filename' => '/var/www/html/templates/rt_photon/blueprints/styles/accent.yaml',
    'modified' => 1519682534,
    'data' => [
        'name' => 'Accent Colors',
        'description' => 'Accent colors for the Photon theme',
        'type' => 'core',
        'form' => [
            'fields' => [
                'color-1' => [
                    'type' => 'input.colorpicker',
                    'label' => 'Accent Color 1',
                    'default' => '#0193da'
                ],
                'color-2' => [
                    'type' => 'input.colorpicker',
                    'label' => 'Accent Color 2',
                    'default' => '#cc2984'
                ],
                'color-3' => [
                    'type' => 'input.colorpicker',
                    'label' => 'Accent Color 3',
                    'default' => '#28134c'
                ],
                'color-4' => [
                    'type' => 'input.colorpicker',
                    'label' => 'Accent Color 4',
                    'default' => '#ffa200'
                ]
            ]
        ]
    ]
];
