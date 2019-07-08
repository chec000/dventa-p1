<?php
return [
    '@class' => 'Gantry\\Component\\File\\CompiledYamlFile',
    'filename' => 'C:/xampp/htdocs/dventa/templates/rt_photon/custom/particles/hover.yaml',
    'modified' => 1519682534,
    'data' => [
        'name' => 'Hover',
        'description' => 'Hover library to add effect when hovering button',
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
                    'content' => '<center>This is a library to add effect when hovering button<br>After enable, add class name of hover effect to your element.<br> For example &lt;a href="" class="hvr-shutter-in-vertical"&gt; &lt;/a&gt.</center>'
                ],
                'copyright' => [
                    'type' => 'separator.note',
                    'class' => 'alert alert-info',
                    'content' => 'Developed and maintained by <a href="https://www.joomlead.com/" target="_blank">JoomLead.com</a><br><strong>Version: 1.0.0</strong>'
                ]
            ]
        ]
    ]
];
