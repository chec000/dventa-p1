<?php
return [
    '@class' => 'Gantry\\Component\\File\\CompiledYamlFile',
    'filename' => '/home1/adboxadm/public_html/incentiva/templates/rt_photon/particles/blockcontent.yaml',
    'modified' => 1519682534,
    'data' => [
        'name' => 'Block Content',
        'description' => 'Displays Block Content',
        'type' => 'particle',
        'icon' => 'fa-th-large',
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
                    'description' => 'Globally enable the particle.',
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
                'icon' => [
                    'type' => 'input.icon',
                    'label' => 'Icon',
                    'description' => 'Select the icon.'
                ],
                'image' => [
                    'type' => 'input.imagepicker',
                    'label' => 'Image',
                    'description' => 'Select the main image.'
                ],
                'headline' => [
                    'type' => 'input.text',
                    'label' => 'Headline',
                    'description' => 'Customize the headline text.',
                    'placeholder' => 'Enter headline'
                ],
                'description' => [
                    'type' => 'textarea.textarea',
                    'label' => 'Description',
                    'description' => 'Customize the description.',
                    'placeholder' => 'Enter short description'
                ],
                'linktext' => [
                    'type' => 'input.text',
                    'label' => 'Button Label',
                    'description' => 'Customize the button label.'
                ],
                'link' => [
                    'type' => 'input.text',
                    'label' => 'Button Link',
                    'description' => 'Specify the button link address.'
                ],
                'linkclass' => [
                    'type' => 'input.selectize',
                    'label' => 'Button Classes',
                    'description' => 'CSS class names for the button.'
                ],
                'linktarget' => [
                    'type' => 'select.selectize',
                    'label' => 'Target',
                    'description' => 'Target browser window when item is clicked.',
                    'placeholder' => 'Select...',
                    'default' => '_self',
                    'options' => [
                        '_self' => 'Self',
                        '_blank' => 'New Window'
                    ]
                ],
                'subcontents' => [
                    'type' => 'collection.list',
                    'array' => true,
                    'label' => 'Content Items',
                    'description' => 'Create each item to appear in the content row.',
                    'value' => 'title',
                    'ajax' => true,
                    'fields' => [
                        '.name' => [
                            'type' => 'input.text',
                            'label' => 'Title',
                            'description' => 'Enter title.'
                        ],
                        '.icon' => [
                            'type' => 'input.icon',
                            'label' => 'Icon',
                            'description' => 'Select the icon.'
                        ],
                        '.img' => [
                            'type' => 'input.imagepicker',
                            'label' => 'Image',
                            'description' => 'Select the image.'
                        ],
                        '.rokboximage' => [
                            'type' => 'input.imagepicker',
                            'label' => 'Lightcase Image',
                            'description' => 'Select the Lightcase Image.'
                        ],
                        '.rokboxcaption' => [
                            'type' => 'input.text',
                            'label' => 'Caption',
                            'description' => 'Customize the rokbox caption.',
                            'placeholder' => 'Enter caption'
                        ],
                        '.subtitle' => [
                            'type' => 'input.text',
                            'label' => 'Subtitle',
                            'description' => 'Enter subtitle.'
                        ],
                        '.description' => [
                            'type' => 'textarea.textarea',
                            'label' => 'Description',
                            'description' => 'Enter the descriptiopn.'
                        ],
                        '.class' => [
                            'type' => 'input.selectize',
                            'label' => 'CSS Classes',
                            'description' => 'CSS class name for the particle.'
                        ],
                        '.button' => [
                            'type' => 'input.text',
                            'label' => 'Button Label',
                            'description' => 'Specify the button label.'
                        ],
                        '.buttonlink' => [
                            'type' => 'input.text',
                            'label' => 'Button Link',
                            'description' => 'Specify the button link.'
                        ],
                        '.buttonclass' => [
                            'type' => 'input.selectize',
                            'label' => 'Button Classes',
                            'description' => 'CSS class names for the button.'
                        ],
                        '.buttontarget' => [
                            'type' => 'select.selectize',
                            'label' => 'Target',
                            'description' => 'Target browser window when item is clicked.',
                            'placeholder' => 'Select...',
                            'default' => '_self',
                            'options' => [
                                '_self' => 'Self',
                                '_blank' => 'New Window'
                            ]
                        ]
                    ]
                ]
            ]
        ]
    ]
];
