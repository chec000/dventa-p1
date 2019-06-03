<?php
return [
    '@class' => 'Gantry\\Component\\File\\CompiledYamlFile',
    'filename' => '/home1/adboxadm/public_html/incentiva/templates/rt_photon/particles/pricingtable.yaml',
    'modified' => 1519682534,
    'data' => [
        'name' => 'Pricing Table',
        'description' => 'Display Pricing Table items.',
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
                'headertext' => [
                    'type' => 'textarea.textarea',
                    'label' => 'Header Text',
                    'description' => 'Customize the header text.',
                    'placeholder' => 'Enter short header text'
                ],
                'footertext' => [
                    'type' => 'textarea.textarea',
                    'label' => 'Footer Text',
                    'description' => 'Customize the footer text.',
                    'placeholder' => 'Enter short footer text'
                ],
                'columns' => [
                    'type' => 'select.selectize',
                    'label' => 'Grid Columns',
                    'description' => 'Select the Grid columns amount.',
                    'default' => 'g-pricingtable-3-col',
                    'options' => [
                        'g-pricingtable-1-col' => '1 Column',
                        'g-pricingtable-2-col' => '2 Columns',
                        'g-pricingtable-3-col' => '3 Columns',
                        'g-pricingtable-4-col' => '4 Columns',
                        'g-pricingtable-5-col' => '5 Columns',
                        'g-pricingtable-6-col' => '6 Columns'
                    ]
                ],
                'tables' => [
                    'type' => 'collection.list',
                    'array' => true,
                    'label' => 'Tables',
                    'description' => 'Create each table to display.',
                    'value' => 'plan',
                    'ajax' => true,
                    'fields' => [
                        '.accent' => [
                            'type' => 'select.selectize',
                            'label' => 'Accent Color',
                            'description' => 'Specify accent color for your table',
                            'placeholder' => 'Select...',
                            'default' => 'accent1',
                            'options' => [
                                'accent1' => 'Accent Color 1',
                                'accent2' => 'Accent Color 2',
                                'accent3' => 'Accent Color 3',
                                'accent4' => 'Accent Color 4'
                            ]
                        ],
                        '.customcolor' => [
                            'type' => 'input.colorpicker',
                            'label' => 'Custom Color',
                            'description' => 'Custom table color (accent color will be overwritten)'
                        ],
                        '.class' => [
                            'type' => 'input.selectize',
                            'label' => 'CSS Classes',
                            'description' => 'CSS class name for the particle.'
                        ],
                        '.ribbon' => [
                            'type' => 'input.text',
                            'label' => 'Ribbon Text',
                            'description' => 'Input the corner ribbon text.'
                        ],
                        '.icon' => [
                            'type' => 'input.icon',
                            'label' => 'Icon',
                            'description' => 'Input the icon.'
                        ],
                        '.plan' => [
                            'type' => 'input.text',
                            'label' => 'Plan Name',
                            'description' => 'Customize the table plan name text.',
                            'placeholder' => 'Enter plan name'
                        ],
                        '.price' => [
                            'type' => 'input.text',
                            'label' => 'Price',
                            'description' => 'Customize the price.',
                            'placeholder' => '$100'
                        ],
                        '.period' => [
                            'type' => 'input.text',
                            'label' => 'Period',
                            'description' => 'Customize the period.',
                            'placeholder' => 'monthly'
                        ],
                        '.desc' => [
                            'type' => 'textarea.textarea',
                            'label' => 'Description',
                            'description' => 'Customize the description.',
                            'placeholder' => 'Enter short description'
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
                            'type' => 'input.selectize',
                            'label' => 'Button Classes',
                            'description' => 'CSS class names for the button.'
                        ],
                        '.items' => [
                            'type' => 'collection.list',
                            'array' => true,
                            'label' => 'Items',
                            'description' => 'Create the items for your table.',
                            'value' => 'title',
                            'ajax' => true,
                            'fields' => [
                                '.text' => [
                                    'type' => 'input.text',
                                    'label' => 'Text',
                                    'description' => 'Create the items for your table.'
                                ],
                                '.class' => [
                                    'type' => 'input.selectize',
                                    'label' => 'Item Classes',
                                    'description' => 'Enter the CSS class.'
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ]
    ]
];
