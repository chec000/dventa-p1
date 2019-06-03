<?php
return [
    '@class' => 'Gantry\\Component\\File\\CompiledYamlFile',
    'filename' => '/var/www/html/templates/rt_photon/blueprints/styles/base.yaml',
    'modified' => 1519682534,
    'data' => [
        'name' => 'Base Styles',
        'description' => 'Base styles for the Photon theme',
        'type' => 'core',
        'form' => [
            'fields' => [
                'background' => [
                    'type' => 'input.colorpicker',
                    'label' => 'Base Background',
                    'default' => '#ffffff'
                ],
                'text-color' => [
                    'type' => 'input.colorpicker',
                    'label' => 'Base Text Color',
                    'default' => '#686868'
                ]
            ]
        ]
    ]
];
