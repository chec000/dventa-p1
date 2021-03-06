<?php
return [
    '@class' => 'Gantry\\Component\\File\\CompiledYamlFile',
    'filename' => '/var/www/html/templates/rt_photon/custom/particles/testimonial.yaml',
    'modified' => 1519682534,
    'data' => [
        'name' => 'Testimonial',
        'description' => 'Displays Testimonial',
        'type' => 'particle',
        'icon' => 'fa-commenting-o',
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
                'intro' => [
                    'type' => 'textarea.textarea',
                    'label' => 'Intro',
                    'description' => 'Customize the intro text.',
                    'placeholder' => 'Enter short description'
                ],
                'cols' => [
                    'type' => 'select.select',
                    'label' => 'Grid Column',
                    'description' => 'Select the grid column amount for the testimonials',
                    'placeholder' => 'Select...',
                    'default' => 'g-1cols',
                    'options' => [
                        'g-1cols' => '1 Column',
                        'g-2cols' => '2 Columns',
                        'g-3cols' => '3 Columns',
                        'g-4cols' => '4 Columns',
                        'g-5cols' => '5 Columns'
                    ]
                ],
                'testimonials' => [
                    'type' => 'collection.list',
                    'array' => true,
                    'label' => 'Testimonials',
                    'description' => 'Create each item to appear in the content row.',
                    'value' => 'title',
                    'ajax' => true,
                    'fields' => [
                        '.style' => [
                            'type' => 'select.select',
                            'label' => 'Testimonial Style',
                            'description' => 'Select the style for the testimonials',
                            'placeholder' => 'Select...',
                            'default' => 'g-testimonial-standard',
                            'options' => [
                                'g-testimonial-standard' => 'Standard',
                                'g-testimonial-alt' => 'Alternative'
                            ]
                        ],
                        '.img' => [
                            'type' => 'input.imagepicker',
                            'label' => 'Image'
                        ],
                        '.content' => [
                            'type' => 'textarea.textarea',
                            'label' => 'Content'
                        ],
                        '.author' => [
                            'type' => 'input.text',
                            'label' => 'Author'
                        ],
                        '.company' => [
                            'type' => 'input.text',
                            'label' => 'Company'
                        ],
                        '.companyurl' => [
                            'type' => 'input.text',
                            'label' => 'Link'
                        ]
                    ]
                ]
            ]
        ]
    ]
];
