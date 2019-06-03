<?php
return [
    '@class' => 'Gantry\\Component\\File\\CompiledYamlFile',
    'filename' => 'C:\\xampp\\htdocs\\dventa/templates/rt_photon/custom/particles/bg-video.yaml',
    'modified' => 1519682534,
    'data' => [
        'name' => 'BG-Video',
        'description' => 'Incrustar video como fondo de la pagina',
        'type' => 'atom',
        'form' => [
            'fields' => [
                'enabled' => [
                    'type' => 'input.checkbox',
                    'label' => 'Enabled',
                    'description' => 'Habilitar',
                    'default' => true
                ],
                'jquery' => [
                    'type' => 'enable.enable',
                    'label' => 'Jquery',
                    'description' => 'Carga la librería de Jquery',
                    'default' => true
                ],
                'urlVideo' => [
                    'type' => 'input.url',
                    'label' => 'Video Url',
                    'description' => 'Url de Youtube',
                    'default' => 'https://www.youtube.com/watch?v=gyHJmfI9iFE',
                    'required' => true
                ],
                'controls' => [
                    'type' => 'enable.enable',
                    'label' => 'Mostrar controles',
                    'description' => 'Mostrar controles de video al pie de pagina',
                    'default' => false
                ],
                'loop' => [
                    'type' => 'enable.enable',
                    'label' => 'Loop',
                    'description' => 'Habilitar loop',
                    'default' => true
                ],
                'opacity' => [
                    'type' => 'select.select',
                    'label' => 'Opacidad',
                    'description' => 'Seleccione el porcentaje de opacidad',
                    'options' => [
                        '0.1' => '10%',
                        '0.2' => '20%',
                        '0.3' => '30%',
                        '0.4' => '40%',
                        '0.5' => '50%',
                        '0.6' => '60%',
                        '0.7' => '70%',
                        '0.8' => '80%',
                        '0.9' => '90%',
                        1 => '100%'
                    ],
                    'default' => 1
                ],
                'mute' => [
                    'type' => 'enable.enable',
                    'label' => 'Mute',
                    'description' => 'Silenciar',
                    'default' => true
                ],
                'startAt' => [
                    'type' => 'input.number',
                    'label' => 'Inicio del video',
                    'description' => 'Segundo en el que debe iniciar el video ',
                    'default' => '0',
                    'required' => true
                ],
                'info' => [
                    'type' => 'separator.note',
                    'class' => 'alert alert-warning',
                    'content' => 'Este átomo solo soporta videos hosteados en Youtube'
                ],
                'copyright' => [
                    'type' => 'separator.note',
                    'class' => 'alert alert-info',
                    'content' => 'Desarrollado por Adventa <a href="http://adventa.com.mx/" target="_blank">Adventa</a><br><strong>Version: 1.0.0</strong>'
                ]
            ]
        ]
    ]
];
