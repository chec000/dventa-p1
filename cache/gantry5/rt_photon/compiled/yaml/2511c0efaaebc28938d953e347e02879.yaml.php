<?php
return [
    '@class' => 'Gantry\\Component\\File\\CompiledYamlFile',
    'filename' => '/home1/adboxadm/public_html/incentiva/templates/rt_photon/custom/particles/popup.yaml',
    'modified' => 1519682534,
    'data' => [
        'name' => 'Popup',
        'description' => 'Genera una ventana modal (Popup) en el sitio',
        'type' => 'atom',
        'form' => [
            'fields' => [
                'enabled' => [
                    'type' => 'enable.enable',
                    'label' => 'Enabled',
                    'description' => 'Habilitar',
                    'default' => true
                ],
                'message' => [
                    'type' => 'input.text',
                    'label' => 'Contenido',
                    'description' => 'Ingrese el contenido a mostrar en el popup',
                    'default' => 'Adventa'
                ],
                'image' => [
                    'type' => 'input.imagepicker',
                    'label' => 'Imagen',
                    'description' => 'Selecciona la imagen'
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
