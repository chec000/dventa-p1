<?php
return [
    '@class' => 'Gantry\\Component\\File\\CompiledYamlFile',
    'filename' => 'C:/xampp/htdocs/dventa/templates/rt_photon/gantry/theme.yaml',
    'modified' => 1519682534,
    'data' => [
        'details' => [
            'name' => 'Photon',
            'version' => '1.0.6',
            'icon' => 'paper-plane',
            'date' => 'June 21, 2017',
            'author' => [
                'name' => 'RocketTheme, LLC',
                'email' => 'support@rockettheme.com',
                'link' => 'http://www.rockettheme.com'
            ],
            'documentation' => [
                'link' => 'http://docs.gantry.org/gantry5'
            ],
            'support' => [
                'link' => 'https://gitter.im/gantry/gantry5'
            ],
            'updates' => [
                'link' => 'http://updates.rockettheme.com/themes/photon.yaml'
            ],
            'copyright' => '(C) 2007 - 2016 RocketTheme, LLC. All rights reserved.',
            'license' => 'GPLv2',
            'description' => 'Photon Theme',
            'images' => [
                'thumbnail' => 'admin/images/preset1.png',
                'preview' => 'admin/images/preset1.png'
            ]
        ],
        'configuration' => [
            'gantry' => [
                'platform' => 'joomla',
                'engine' => 'nucleus'
            ],
            'theme' => [
                'parent' => 'rt_photon',
                'base' => 'gantry-theme://common',
                'file' => 'gantry-theme://include/theme.php',
                'class' => '\\Gantry\\Framework\\Theme'
            ],
            'fonts' => [
                'dosis' => [
                    700 => 'gantry-theme://fonts/dosis/dosis-bold/dosis-bold-webfont',
                    400 => 'gantry-theme://fonts/dosis/dosis-regular/dosis-regular-webfont',
                    200 => 'gantry-theme://fonts/dosis/dosis-light/dosis-light-webfont'
                ],
                'opensans' => [
                    '700italic' => 'gantry-theme://fonts/opensans/opensans-bolditalic/opensans-bolditalic-webfont',
                    700 => 'gantry-theme://fonts/opensans/opensans-bold/opensans-bold-webfont',
                    '400italic' => 'gantry-theme://fonts/opensans/opensans-italic/opensans-italic-webfont',
                    400 => 'gantry-theme://fonts/opensans/opensans-regular/opensans-regular-webfont',
                    '200italic' => 'gantry-theme://fonts/opensans/opensans-lightitalic/opensans-lightitalic-webfont',
                    200 => 'gantry-theme://fonts/opensans/opensans-light/opensans-light-webfont'
                ]
            ],
            'css' => [
                'compiler' => '\\Gantry\\Component\\Stylesheet\\ScssCompiler',
                'target' => 'gantry-theme://css-compiled',
                'paths' => [
                    0 => 'gantry-theme://scss',
                    1 => 'gantry-engine://scss'
                ],
                'files' => [
                    0 => 'photon',
                    1 => 'photon-joomla',
                    2 => 'custom'
                ],
                'persistent' => [
                    0 => 'photon'
                ],
                'overrides' => [
                    0 => 'photon-joomla',
                    1 => 'custom'
                ]
            ],
            'block-variations' => [
                'Title Variations' => [
                    'title1' => 'Title 1',
                    'title2' => 'Title 2',
                    'title3' => 'Title 3',
                    'title4' => 'Title 4',
                    'title5' => 'Title 5',
                    'title6' => 'Title 6',
                    'title-grey' => 'Title Grey',
                    'title-pink' => 'Title Pink',
                    'title-red' => 'Title Red',
                    'title-purple' => 'Title Purple',
                    'title-orange' => 'Title Orange',
                    'title-blue' => 'Title Blue',
                    'title-underline' => 'Title Underline',
                    'title-rounded' => 'Title Rounded'
                ],
                'Box Variations' => [
                    'box1' => 'Box 1',
                    'box2' => 'Box 2',
                    'box3' => 'Box 3',
                    'box4' => 'Box 4',
                    'box5' => 'Box 5',
                    'box6' => 'Box 6',
                    'box-white' => 'Box White',
                    'box-grey' => 'Box Grey',
                    'box-pink' => 'Box Pink',
                    'box-red' => 'Box Red',
                    'box-purple' => 'Box Purple',
                    'box-orange' => 'Box Orange',
                    'box-blue' => 'Box Blue'
                ],
                'Effects' => [
                    'spaced' => 'Spaced',
                    'bordered' => 'Bordered',
                    'shadow' => 'Shadow 1',
                    'shadow2' => 'Shadow 2',
                    'rounded' => 'Rounded',
                    'square' => 'Square'
                ],
                'Utility' => [
                    'equal-height' => 'Equal Height',
                    'g-outer-box' => 'Outer Box',
                    'disabled' => 'Disabled',
                    'align-right' => 'Align Right',
                    'align-left' => 'Align Left',
                    'title-center' => 'Centered Title',
                    'center' => 'Center',
                    'nomarginall' => 'No Margin',
                    'nopaddingall' => 'No Padding'
                ]
            ]
        ],
        'admin' => [
            'styles' => [
                'core' => [
                    0 => 'base',
                    1 => 'accent',
                    2 => 'font'
                ],
                'section' => [
                    0 => 'overlay',
                    1 => 'top',
                    2 => 'navigation',
                    3 => 'slideshow',
                    4 => 'header',
                    5 => 'above',
                    6 => 'showcase',
                    7 => 'utility',
                    8 => 'feature',
                    9 => 'aside',
                    10 => 'mainbar',
                    11 => 'sidebar',
                    12 => 'expanded',
                    13 => 'extension',
                    14 => 'bottom',
                    15 => 'footer',
                    16 => 'copyright',
                    17 => 'offcanvas'
                ],
                'configuration' => [
                    0 => 'breakpoints'
                ]
            ]
        ]
    ]
];
