<?php
return [
    '@class' => 'Gantry\\Component\\File\\CompiledYamlFile',
    'filename' => 'C:/xampp/htdocs/dventa/templates/rt_photon/particles/block-application.yaml',
    'modified' => 1560962305,
    'data' => [
        'name' => 'Block Application',
        'description' => 'Block the application if the browser is IE',
        'type' => 'atom',
        'form' => [
            'fields' => [
                'enabled' => [
                    'type' => 'input.checkbox',
                    'label' => 'Enabled',
                    'description' => 'Globally enable to the particles.',
                    'default' => true
                ],
                'tutorial' => [
                    'type' => 'separator.note',
                    'class' => 'alert alert-info',
                    'content' => '<center>This is atom which functionality is to block the application when the browser is IE</center>'
                ],
                'copyright' => [
                    'type' => 'separator.note',
                    'class' => 'alert alert-info',
                    'content' => 'Developed and maintained by <a href="https://www.joomlead.com/" target="_blank">aventa.com</a><br><strong>Version: 1.0.0</strong>'
                ]
            ]
        ]
    ]
];
