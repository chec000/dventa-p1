<?php
return [
    '@class' => 'Gantry\\Component\\File\\CompiledYamlFile',
    'filename' => '/home1/adboxadm/public_html/incentiva/templates/rt_photon/custom/particles/atomo-Ir-arriba.yaml',
    'modified' => 1519682534,
    'data' => [
        'name' => 'Ir arriba',
        'description' => 'Wow.js muestra las animaciones basadas en Animate.css a medida que se hace scroll sobre la página. Por su parte Animate.css es una colección de animaciones basadas en CSS3.',
        'type' => 'atom',
        'form' => [
            'fields' => [
                'enabled' => [
                    'type' => 'input.checkbox',
                    'label' => 'Enabled',
                    'description' => 'Habilitar Globalmente Animate.css.',
                    'default' => true
                ],
                '_info' => [
                    'type' => 'separator.note',
                    'class' => 'alert alert-info',
                    'content' => 'Este Átomo te permite mostrar un botón en la parte inferior de tu página que te dirijirá a la parte superior usando un deslizamiento suave.'
                ],
                'offset' => [
                    'type' => 'input.text',
                    'label' => 'Offset',
                    'description' => 'Define la distancia mínima necesaria que el usuario debe hacer Scroll para mostrar el botón.(NO escribir\'px\', ingrese sólo números).',
                    'default' => '200'
                ],
                'efecto' => [
                    'type' => 'select.select',
                    'label' => 'Efecto',
                    'description' => 'Efecto del botón.',
                    'placeholder' => 'Seleccionar...',
                    'default' => 'estilo1',
                    'options' => [
                        'estilo1' => 'Estilo 1',
                        'estilo2' => 'Estilo 2',
                        'estilo3' => 'Estilo 3',
                        'estilo4' => 'Estilo 4'
                    ]
                ],
                'buttonicon' => [
                    'type' => 'input.icon',
                    'label' => 'Ícono del botón',
                    'description' => 'Selecciona el ícono para el botón.',
                    'default' => 'fa fa-angle-up'
                ],
                'colorfondo' => [
                    'type' => 'input.colorpicker',
                    'label' => 'Color de fondo',
                    'default' => 'rgba(0, 0, 0, 0.4)'
                ],
                'coloricono' => [
                    'type' => 'input.colorpicker',
                    'label' => 'Color de Ícono',
                    'default' => '#ffffff'
                ],
                'border-radius' => [
                    'type' => 'input.text',
                    'label' => 'Borde redondeado',
                    'description' => 'Tambien puede usar px o rem (50% para obtener un circulo perfecto).',
                    'default' => '50%'
                ],
                'anchura' => [
                    'type' => 'input.text',
                    'label' => 'Ancho del botón',
                    'description' => 'Defina el ancho del botón.',
                    'default' => '30px'
                ],
                'altura' => [
                    'type' => 'input.text',
                    'label' => 'Altura del botón',
                    'description' => 'Defina la altura del botón.',
                    'default' => '30px'
                ],
                'velocidadscroll' => [
                    'type' => 'input.text',
                    'label' => 'Velocidad del Scroll',
                    'description' => 'Defina el tiempo en milisegundos que se demorará en desplazarse hacia arriba de la página.',
                    'default' => '500'
                ]
            ]
        ]
    ]
];
