<?php
return [
    '@class' => 'Gantry\\Component\\File\\CompiledYamlFile',
    'filename' => '/var/www/html/templates/rt_photon/custom/particles/mosaicgrid.yaml',
    'modified' => 1519682534,
    'data' => [
        'name' => 'Mosaic Grid',
        'description' => 'Display Mosaic Grid content.',
        'type' => 'particle',
        'icon' => 'fa-th',
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
                'columns' => [
                    'type' => 'select.selectize',
                    'label' => 'Grid Columns',
                    'description' => 'Select the Mosaic Grid columns.',
                    'default' => 'g-mosaicgrid-3-col',
                    'options' => [
                        'g-mosaicgrid-1-col' => '1 Column',
                        'g-mosaicgrid-2-col' => '2 Columns',
                        'g-mosaicgrid-3-col' => '3 Columns',
                        'g-mosaicgrid-4-col' => '4 Columns',
                        'g-mosaicgrid-5-col' => '5 Columns',
                        'g-mosaicgrid-6-col' => '6 Columns'
                    ]
                ],
                'items' => [
                    'type' => 'collection.list',
                    'array' => true,
                    'label' => 'Items',
                    'description' => 'Create each item to appear in the content row.',
                    'value' => 'title',
                    'ajax' => true,
                    'fields' => [
                        '.style' => [
                            'type' => 'select.selectize',
                            'label' => 'Style',
                            'description' => 'Select the style for the Mosaic Grid item.',
                            'default' => 'g-mosaicgrid-style1',
                            'options' => [
                                'g-mosaicgrid-style1' => 'Style 1',
                                'g-mosaicgrid-style2' => 'Style 2'
                            ]
                        ],
                        '.img' => [
                            'type' => 'input.imagepicker',
                            'label' => 'Image',
                            'description' => 'Select desired image.'
                        ],
                        '.titleText' => [
                            'type' => 'input.text',
                            'label' => 'Title Label',
                            'description' => 'Specify the title label.'
                        ],
                        '.titleURL' => [
                            'type' => 'input.text',
                            'label' => 'Title Link',
                            'description' => 'Specify the title link.'
                        ],
                        '.titleTarget' => [
                            'type' => 'select.selectize',
                            'label' => 'Title Link Target',
                            'description' => 'Target browser window when item is clicked.',
                            'placeholder' => 'Select...',
                            'default' => '_self',
                            'options' => [
                                '_self' => 'Self',
                                '_blank' => 'New Window'
                            ]
                        ],
                        '.desc' => [
                            'type' => 'textarea.textarea',
                            'label' => 'Description',
                            'description' => 'Customize the description.',
                            'placeholder' => 'Enter short description'
                        ],
                        '.animations' => [
                            'type' => 'input.selectize',
                            'label' => 'Animations',
                            'description' => 'Choose the Animation(s) when hovering the item: g-mosaicgrid-zoom, g-mosaicgrid-blur, g-mosaicgrid-rotate, g-mosaicgrid-grayscale.',
                            'default' => 'g-mosaicgrid-zoom',
                            'options' => [
                                'g-mosaicgrid-zoom' => 'Zoom',
                                'g-mosaicgrid-blur' => 'Blur',
                                'g-mosaicgrid-rotate' => 'Rotate',
                                'g-mosaicgrid-grayscale' => 'Grayscale'
                            ]
                        ],
                        '.buttontext' => [
                            'type' => 'input.text',
                            'label' => 'Button Label',
                            'description' => 'Specify the button label.'
                        ],
                        '.buttonlink' => [
                            'type' => 'input.text',
                            'label' => 'Button Link',
                            'description' => 'Specify the button link.'
                        ],
                        '.buttontarget' => [
                            'type' => 'select.selectize',
                            'label' => 'Button Link Target',
                            'description' => 'Target browser window when item is clicked.',
                            'placeholder' => 'Select...',
                            'default' => '_self',
                            'options' => [
                                '_self' => 'Self',
                                '_blank' => 'New Window'
                            ]
                        ],
                        '.buttonclass' => [
                            'type' => 'input.selectize',
                            'label' => 'Button Classes',
                            'description' => 'CSS class names for the button.'
                        ],
                        '.tag' => [
                            'type' => 'input.text',
                            'label' => 'Tag',
                            'description' => 'Customize the Tag.',
                            'placeholder' => 'Enter Tag'
                        ],
                        '.tagicons' => [
                            'type' => 'collection.list',
                            'array' => true,
                            'label' => 'Tag Icons',
                            'description' => 'Create each tag icon to appear in the content row.',
                            'value' => 'title',
                            'ajax' => true,
                            'fields' => [
                                '.iconitem' => [
                                    'type' => 'input.icon',
                                    'label' => 'Icon',
                                    'description' => 'Choose the Icon.'
                                ],
                                '.icontext' => [
                                    'type' => 'input.text',
                                    'label' => 'Icon Text',
                                    'description' => 'Customize the Icon Text.',
                                    'placeholder' => 'Enter Icon Text'
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ]
    ]
];
