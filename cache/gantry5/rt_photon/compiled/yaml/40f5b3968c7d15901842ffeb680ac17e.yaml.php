<?php
return [
    '@class' => 'Gantry\\Component\\File\\CompiledYamlFile',
    'filename' => '/home1/adboxadm/public_html/incentiva/templates/rt_photon/blueprints/styles/header.yaml',
    'modified' => 1519682534,
    'data' => [
        'name' => 'Header Styles',
        'description' => 'Header styles for the Photon theme',
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
