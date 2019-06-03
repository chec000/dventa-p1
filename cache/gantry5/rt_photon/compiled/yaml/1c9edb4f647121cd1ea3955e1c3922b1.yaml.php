<?php
return [
    '@class' => 'Gantry\\Component\\File\\CompiledYamlFile',
    'filename' => '/var/www/html/templates/rt_photon/custom/particles/bg-slider.yaml',
    'modified' => 1519682534,
    'data' => [
        'name' => 'BG-Slider',
        'description' => 'Efecto tipo slider para la imagen de fondo de la pagina',
        'type' => 'atom',
        'form' => [
            'fields' => [
                'enabled' => [
                    'type' => 'enable.enable',
                    'label' => 'Enabled',
                    'description' => 'Habilitar',
                    'default' => true
                ],
                'jquery' => [
                    'type' => 'input.checkbox',
                    'label' => 'Cargar librería?',
                    'description' => 'Carga la librería de Jquery',
                    'default' => true
                ],
                'path' => [
                    'type' => 'input.text',
                    'label' => 'Folder',
                    'description' => 'Carpeta donde se encuentran las imagenes',
                    'default' => 'images/',
                    'required' => true
                ],
                'timmer' => [
                    'type' => 'input.text',
                    'label' => 'Timer',
                    'description' => 'Tiempo entre transiciones (milisegundos)',
                    'default' => '4000',
                    'required' => true
                ],
                'effect' => [
                    'type' => 'select.select',
                    'label' => 'Efecto',
                    'description' => 'Seleccione el efecto para la transición',
                    'default' => 'blur',
                    'options' => [
                        'blur' => 'Blur',
                        'fade' => 'Fade',
                        'slideUp' => 'Slide Up',
                        'slideRight' => 'Slide Right',
                        'slideLeft' => 'Slide Left',
                        'slideDown' => 'Slide Down',
                        'zoomBlur' => 'Zoom Blur',
                        'zoom' => 'Zoom'
                    ],
                    'required' => true
                ],
                'transitionTime' => [
                    'type' => 'input.text',
                    'label' => 'Transition Timer',
                    'description' => 'Duración de la transición (milisegundos)',
                    'default' => '2000',
                    'required' => true
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
