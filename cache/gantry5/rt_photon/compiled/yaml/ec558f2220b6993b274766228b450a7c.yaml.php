<?php
return [
    '@class' => 'Gantry\\Component\\File\\CompiledYamlFile',
    'filename' => '/var/www/html/templates/rt_photon/particles/contenttabs.yaml',
    'modified' => 1519682534,
    'data' => [
        'name' => 'Content Tabs',
        'description' => 'Display Content Tabs.',
        'type' => 'particle',
        'icon' => 'fa-table',
        'configuration' => [
            'caching' => [
                'type' => 'static'
            ]
        ],
        'form' => [
            'fields' => [
                'enabled' => [
                    'type' => 'input.checkbox',
                    'label' => 'Enabled',
                    'description' => 'Globally enable icon menu particles.',
                    'default' => true
                ],
                'class' => [
                    'type' => 'input.selectize',
                    'label' => 'CSS Classes',
                    'description' => 'CSS class name for the particle.'
                ],
                'title' => [
                    'type' => 'input.text',
                    'label' => 'Title',
                    'description' => 'Customize the title text.',
                    'placeholder' => 'Enter title'
                ],
                'animation' => [
                    'type' => 'select.select',
                    'label' => 'Animation Type',
                    'description' => 'Set the animation type.',
                    'default' => 'slide',
                    'options' => [
                        'left' => 'Slide Left',
                        'right' => 'Slide Right',
                        'up' => 'Slide Up',
                        'down' => 'Slide Down',
                        'fade' => 'Fade',
                        'toggle' => 'Toggle'
                    ]
                ],
                'duration' => [
                    'type' => 'input.text',
                    'label' => 'Duration',
                    'description' => 'Customize the animation duration.',
                    'placeholder' => 500
                ],
                'items' => [
                    'type' => 'collection.list',
                    'array' => true,
                    'label' => 'ContentTabs Items',
                    'description' => 'Create each ContentTabs item to display.',
                    'value' => 'name',
                    'ajax' => true,
                    'fields' => [
                        '.tabname' => [
                            'type' => 'input.text',
                            'label' => 'Tab Name',
                            'description' => 'Enter the Tab name (Each tab must have unique name)'
                        ],
                        '.title' => [
                            'type' => 'input.text',
                            'label' => 'Title',
                            'description' => 'Enter the title'
                        ],
                        '.subtitle' => [
                            'type' => 'input.text',
                            'label' => 'Subtitle',
                            'description' => 'Enter the Subtitle'
                        ],
                        '.desc' => [
                            'type' => 'textarea.textarea',
                            'label' => 'Description',
                            'description' => 'Customize the description.',
                            'placeholder' => 'Enter short description'
                        ],
                        'tags' => [
                            'type' => 'collection.list',
                            'array' => true,
                            'label' => 'Tags',
                            'description' => 'Create tags list.',
                            'value' => 'name',
                            'ajax' => true,
                            'fields' => [
                                '.tag' => [
                                    'type' => 'input.text',
                                    'label' => 'Tag',
                                    'description' => 'Enter the tag'
                                ],
                                '.subtagdotaccent' => [
                                    'type' => 'select.selectize',
                                    'label' => 'Dot Accent Color',
                                    'description' => 'Specify accent color for subtag dot',
                                    'placeholder' => 'Select...',
                                    'default' => 'accent1',
                                    'options' => [
                                        'accent1' => 'Accent Color 1',
                                        'accent2' => 'Accent Color 2',
                                        'accent3' => 'Accent Color 3',
                                        'accent4' => 'Accent Color 4'
                                    ]
                                ],
                                '.subtagdotcustom' => [
                                    'type' => 'input.colorpicker',
                                    'label' => 'Dot Custom Color',
                                    'default' => '',
                                    'description' => 'Enter the subtag dot custom color (accent color will be overwritten)'
                                ],
                                '.subtagtext' => [
                                    'type' => 'input.text',
                                    'label' => 'Subtag Text',
                                    'description' => 'Enter the subtag text'
                                ],
                                '.subtagdesc' => [
                                    'type' => 'textarea.textarea',
                                    'label' => 'Description',
                                    'description' => 'Customize the description.',
                                    'placeholder' => 'Enter short description'
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ]
    ]
];
