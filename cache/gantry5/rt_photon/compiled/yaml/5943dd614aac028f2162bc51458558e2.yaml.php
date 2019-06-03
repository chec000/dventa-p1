<?php
return [
    '@class' => 'Gantry\\Component\\File\\CompiledYamlFile',
    'filename' => 'C:\\xampp\\htdocs\\dventa/templates/rt_photon/blueprints/styles/feature.yaml',
    'modified' => 1519682534,
    'data' => [
        'name' => 'Feature Styles',
        'description' => 'Feature styles for the Photon theme',
        'type' => 'section',
        'form' => [
            'fields' => [
                'background' => [
                    'type' => 'input.colorpicker',
                    'label' => 'Background',
                    'default' => '#ffffff'
                ],
                'text-color' => [
                    'type' => 'input.colorpicker',
                    'label' => 'Text',
                    'default' => '#686868'
                ]
            ]
        ]
    ]
];
