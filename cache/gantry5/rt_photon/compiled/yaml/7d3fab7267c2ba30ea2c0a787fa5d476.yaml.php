<?php
return [
    '@class' => 'Gantry\\Component\\File\\CompiledYamlFile',
    'filename' => 'C:/xampp/htdocs/dventa/templates/rt_photon/blueprints/styles/font.yaml',
    'modified' => 1519682534,
    'data' => [
        'name' => 'Font Families',
        'description' => 'Font families for the Photon theme',
        'type' => 'core',
        'form' => [
            'fields' => [
                'family-default' => [
                    'type' => 'input.fonts',
                    'label' => 'Body Font',
                    'default' => 'opensans, Helvetica, Tahoma, Geneva, Arial, sans-serif'
                ],
                'family-title' => [
                    'type' => 'input.fonts',
                    'label' => 'Title Font',
                    'default' => 'dosis, Helvetica, Tahoma, Geneva, Arial, sans-serif'
                ],
                'family-promo' => [
                    'type' => 'input.fonts',
                    'label' => 'Promo Font',
                    'default' => 'dosis, Helvetica, Tahoma, Geneva, Arial, sans-serif'
                ],
                'family-subpromo' => [
                    'type' => 'input.fonts',
                    'label' => 'SubPromo Font',
                    'default' => 'dosis, Helvetica, Tahoma, Geneva, Arial, sans-serif'
                ]
            ]
        ]
    ]
];
