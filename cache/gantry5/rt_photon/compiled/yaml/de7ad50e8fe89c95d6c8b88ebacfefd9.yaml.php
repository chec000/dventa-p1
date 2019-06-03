<?php
return [
    '@class' => 'Gantry\\Component\\File\\CompiledYamlFile',
    'filename' => '/var/www/html/templates/rt_photon/custom/particles/video-player.yaml',
    'modified' => 1519682534,
    'data' => [
        'name' => 'Video Player',
        'type' => 'particle',
        'icon' => 'fa-video-camera',
        'configuration' => [
            'caching' => [
                'type' => 'static'
            ]
        ],
        'form' => [
            'fields' => [
                'enabled' => [
                    'type' => 'input.checkbox',
                    'label' => 'Publicado',
                    'description' => 'Habilitar o deshabilitar esta particula',
                    'default' => true
                ],
                'Title' => [
                    'type' => 'input.text',
                    'label' => 'Título',
                    'description' => 'Ingresa un título para la partícula',
                    'required' => true
                ],
                'LabelTitle' => [
                    'type' => 'select.select',
                    'label' => 'Tag html del título',
                    'description' => 'Selecciona el estilo de la etiqueta',
                    'default' => 'h3',
                    'options' => [
                        'h1' => 'H1',
                        'h2' => 'H2',
                        'h3' => 'H3',
                        'h4' => 'H4',
                        'h5' => 'H5',
                        'h6' => 'H6'
                    ]
                ],
                'CssClass' => [
                    'type' => 'input.selectize',
                    'label' => 'Clase CSS',
                    'description' => 'Introduce la clase(s) que deseas asignar a la partícula'
                ],
                'SeparatorExternalVideo' => [
                    'type' => 'separator.note',
                    'class' => 'alert alert-default',
                    'content' => '<h4> Video Externo</h4>'
                ],
                'VideoUrl' => [
                    'type' => 'input.url',
                    'label' => 'Url',
                    'description' => 'Url del video en Youtube o Vimeo',
                    'placeholder' => 'https://www.youtube.com/watch?v=mROY2xA6u8g'
                ],
                'SeparatorLocalVideo' => [
                    'type' => 'separator.note',
                    'class' => 'alert alert-default',
                    'content' => '<h4> Video local</h4>'
                ],
                'VideoMP4' => [
                    'type' => 'input.videopicker',
                    'label' => 'MP4',
                    'description' => 'Asigna un video en formato MP4',
                    'filter' => '.(mp4)'
                ],
                'VideoWebm' => [
                    'type' => 'input.videopicker',
                    'label' => 'Webm',
                    'description' => 'Asigna un video en formato Webm para compatibilidad con la mayoría de dispositivos y navegadores',
                    'filter' => '.(webm)'
                ],
                'ImagePreview' => [
                    'type' => 'input.imagepicker',
                    'label' => 'Imagen Previa',
                    'description' => 'Seleccione la imagen para la vista previa del video',
                    'filter' => '.(jpg|png)'
                ],
                'SeparatorConfiguration' => [
                    'type' => 'separator.note',
                    'class' => 'alert alert-default',
                    'content' => '<h4>Opciones de reproducción</h4>'
                ],
                'AutoPlay' => [
                    'type' => 'enable.enable',
                    'label' => 'Autoreproducir',
                    'description' => '¿Deseas que se reproduzca automaticamente?',
                    'default' => false
                ],
                'fullscreen' => [
                    'type' => 'enable.enable',
                    'label' => 'Pantalla completa',
                    'description' => '¿Deseas que el video se pueda ver en pantalla completa?',
                    'default' => true
                ],
                'clickToPlay' => [
                    'type' => 'enable.enable',
                    'label' => 'Click to Play',
                    'description' => 'Pausar - reproducir con un click',
                    'default' => true
                ]
            ]
        ]
    ]
];
