<?php
return [
    '@class' => 'Gantry\\Component\\File\\CompiledYamlFile',
    'filename' => '/home1/adboxadm/public_html/incentiva/templates/rt_photon/custom/particles/atomo-animatecss-wowjs.yaml',
    'modified' => 1519682534,
    'data' => [
        'name' => 'Wow.js y Animate.css',
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
                    'content' => 'Ver la <a href="https://github.com/daneden/animate.css" style="background:white; padding:0 .2rem;" target="_blank"> lista de clases CSS para crear animaciones con animate.css</a> y la <a href="http://mynameismatthieu.com/WOW/docs.html" style="background:white; padding:0 .2rem;" target="_blank">lista de clases CSS para crear efectos con Wow.js.</a><br />Ejemplo de uso:<pre>&lt;div class="wow bounceInUp"><br />Tu contenido<br />&lt;/div></pre>'
                ],
                '_separadoranimate.css' => [
                    'type' => 'separator.note',
                    'class' => 'settings-param',
                    'content' => '<h4>Ajustes de <strong>Animate.css</strong></h4>'
                ],
                '.enabled_animatecss' => [
                    'type' => 'enable.enable',
                    'label' => 'Habilitar Animate.cs',
                    'default' => 0
                ],
                '_separadorwow' => [
                    'type' => 'separator.note',
                    'class' => 'settings-param',
                    'content' => '<h4>Ajustes de <strong>Wow.js</strong></h4>'
                ],
                '.enabled_wowjs' => [
                    'type' => 'enable.enable',
                    'label' => 'Habilitar Wow.js',
                    'default' => 0
                ],
                'offset' => [
                    'type' => 'input.text',
                    'label' => 'Offset',
                    'description' => 'Define la distancia en pixeles que existe entre la parte inferior del navegador con el elemento a animar(NO escribir\'px\', ingrese sólo números).',
                    'default' => '200'
                ],
                'mobile' => [
                    'type' => 'select.select',
                    'label' => 'Movil',
                    'description' => 'Habilitar o deshabilitar las animaciones para dispositivos Moviles.',
                    'placeholder' => 'Seleccionar...',
                    'default' => 'true',
                    'options' => [
                        'true' => 'Habilitar',
                        'false' => 'Deshabilitar'
                    ]
                ]
            ]
        ]
    ]
];
