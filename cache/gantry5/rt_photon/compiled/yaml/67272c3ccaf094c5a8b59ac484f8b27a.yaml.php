<?php
return [
    '@class' => 'Gantry\\Component\\File\\CompiledYamlFile',
    'filename' => 'C:/xampp/htdocs/dventa/templates/rt_photon/particles/owlcarousel.yaml',
    'modified' => 1519682534,
    'data' => [
        'name' => 'Owl Carousel',
        'description' => 'Display Owl Carousel.',
        'type' => 'particle',
        'icon' => 'fa-sliders',
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
                'layout' => [
                    'type' => 'select.select',
                    'label' => 'Layout',
                    'description' => 'Choose the layout.',
                    'default' => 'standard',
                    'options' => [
                        'standard' => 'Standard',
                        'testimonial' => 'Testimonial'
                    ]
                ],
                'width' => [
                    'type' => 'select.select',
                    'label' => 'Width',
                    'description' => 'Choose the width.',
                    'default' => 'g-owlcarousel-fullwidth',
                    'options' => [
                        'g-owlcarousel-fullwidth' => 'Full Width',
                        'g-owlcarousel-compact' => 'Compact'
                    ]
                ],
                'animateOut' => [
                    'type' => 'input.text',
                    'label' => 'Out Animation',
                    'description' => 'Customize the Out Animation from animate css class.',
                    'placeholder' => 'zoomOut'
                ],
                'animateIn' => [
                    'type' => 'input.text',
                    'label' => 'In Animation',
                    'description' => 'Customize the In Animation from animate css class.',
                    'placeholder' => 'fadeIn'
                ],
                'nav' => [
                    'type' => 'select.select',
                    'label' => 'Prev / Next',
                    'description' => 'Enable or disable the Prev / Next navigation.',
                    'default' => true,
                    'options' => [
                        1 => 'Enable',
                        0 => 'Disable'
                    ]
                ],
                'prevText' => [
                    'type' => 'input.text',
                    'label' => 'Prev Text',
                    'description' => 'Customize the Prev text if Prev / Next navigation is enabled.',
                    'placeholder' => NULL
                ],
                'nextText' => [
                    'type' => 'input.text',
                    'label' => 'Next Text',
                    'description' => 'Customize the Nav text if Prev / Next navigation is enabled.',
                    'placeholder' => NULL
                ],
                'dots' => [
                    'type' => 'select.select',
                    'label' => 'Dots',
                    'description' => 'Enable or disable the Dots navigation.',
                    'default' => false,
                    'options' => [
                        1 => 'Enable',
                        0 => 'Disable'
                    ]
                ],
                'loop' => [
                    'type' => 'select.select',
                    'label' => 'Loop',
                    'description' => 'Enable or disable the Inifnity loop. Duplicate last and first items to get loop illusion.',
                    'default' => true,
                    'options' => [
                        1 => 'Enable',
                        0 => 'Disable'
                    ]
                ],
                'autoplay' => [
                    'type' => 'select.select',
                    'label' => 'Autoplay',
                    'description' => 'Enable or disable the Autoplay.',
                    'default' => false,
                    'options' => [
                        1 => 'Enable',
                        0 => 'Disable'
                    ]
                ],
                'autoplaySpeed' => [
                    'type' => 'input.text',
                    'label' => 'Autoplay Speed',
                    'description' => 'Set the speed of the Autoplay, in milliseconds.',
                    'placeholder' => 5000
                ],
                'pauseOnHover' => [
                    'type' => 'select.select',
                    'label' => 'Pause on Hover',
                    'description' => 'Pause the slideshow when hovering over slider, then resume when no longer hovering.',
                    'default' => true,
                    'options' => [
                        1 => 'Enable',
                        0 => 'Disable'
                    ]
                ],
                'footerShadow' => [
                    'type' => 'select.select',
                    'label' => 'Footer Shadow',
                    'description' => 'Enable or disable the footer shadow.',
                    'default' => true,
                    'options' => [
                        1 => 'Enable',
                        0 => 'Disable'
                    ]
                ],
                'footerShadowColor' => [
                    'type' => 'input.colorpicker',
                    'label' => 'Footer Shadow Color',
                    'description' => 'Set the footer shadow if enabled.',
                    'default' => '#20232a'
                ],
                'items' => [
                    'type' => 'collection.list',
                    'array' => true,
                    'label' => 'Owl Carousel Items',
                    'description' => 'Create each Owl Carousel item to display.',
                    'value' => 'name',
                    'ajax' => true,
                    'fields' => [
                        '.image' => [
                            'type' => 'input.imagepicker',
                            'label' => 'Image',
                            'description' => 'Select desired image.'
                        ],
                        '.icon' => [
                            'type' => 'input.icon',
                            'label' => 'Icon'
                        ],
                        '.title' => [
                            'type' => 'input.text',
                            'label' => 'Title',
                            'description' => 'Enter the title'
                        ],
                        '.desc' => [
                            'type' => 'textarea.textarea',
                            'label' => 'Description',
                            'description' => 'Customize the description.',
                            'placeholder' => 'Enter short description'
                        ],
                        '.link' => [
                            'type' => 'input.text',
                            'label' => 'Link',
                            'description' => 'Input the item link.'
                        ],
                        '.linktext' => [
                            'type' => 'input.text',
                            'label' => 'Link Text',
                            'description' => 'Input the text for the item link.'
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
                        ],
                        '.buttonclass' => [
                            'type' => 'input.text',
                            'label' => 'Button Class',
                            'description' => 'Input the button class.'
                        ]
                    ]
                ]
            ]
        ]
    ]
];
