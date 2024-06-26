<?php

return [
    /**
     * If any input file(image) as default will used options below.
     */
    'image' => [
        /**
         * Path for store the image.
         *
         * available options:
         * 1. public
         * 2. storage
         */
        'path' => 'storage',

        /**
         * Will used if image is nullable and default value is null.
         */
        'default' => 'https://via.placeholder.com/350?text=No+Image+Avaiable',

        /**
         * Crop the uploaded image using intervention image.
         */
        'crop' => true,

        /**
         * When set to true the uploaded image aspect ratio will still original.
         */
        'aspect_ratio' => true,

        /**
         * Crop image size.
         */
        'width' => 500,
        'height' => 500,
    ],

    'format' => [
        /**
         * Will used to first year on select, if any column type year.
         */
        'first_year' => 1900,

        /**
         * If any date column type will cast and display used this format, but for input date still will used Y-m-d format.
         *
         * another most common format:
         * - M d Y
         * - d F Y
         * - Y m d
         */
        'date' => 'd/m/Y',

        /**
         * If any input type month will cast and display used this format.
         */
        'month' => 'm/Y',

        /**
         * If any input type time will cast and display used this format.
         */
        'time' => 'H:i',

        /**
         * If any datetime column type or datetime-local on input, will cast and display used this format.
         */
        'datetime' => 'd/m/Y H:i',

        /**
         * Limit string on index view for any column type text or longtext.
         */
        'limit_text' => 100,
    ],

    /**
     * It will used for generator to manage and showing menus on sidebar views.
     *
     * Example:
     * [
     *   'header' => 'Main',
     *
     *   // All permissions in menus[] and submenus[]
     *   'permissions' => ['test view'],
     *
     *   menus' => [
     *       [
     *          'title' => 'Main Data',
     *          'icon' => '<i class="bi bi-collection-fill"></i>',
     *          'route' => null,
     *
     *          // permission always null when isset submenus
     *          'permission' => null,
     *
     *          // All permissions on submenus[] and will empty[] when submenus equals to []
     *          'permissions' => ['test view'],
     *
     *          'submenus' => [
     *                 [
     *                     'title' => 'Tests',
     *                     'route' => '/tests',
     *                     'permission' => 'test view'
     *                  ]
     *               ],
     *           ],
     *       ],
     *  ],
     *
     * This code below always changes when you use a generator and maybe you must lint or format the code.
     */
    'sidebars' => [
        [
            'header' => 'Data Master',
            'permissions' => [
                'jenjang view'
            ],
            'menus' => [
                [
                    'title' => 'Jenjang',
                    'icon' => '<i class="bi bi-mortarboard"></i>',
                    'route' => '/jenjangs',
                    'permission' => 'jenjang view',
                    'permissions' => [],
                    'submenus' => []
                ]
            ]
        ],
        [
            'header' => 'Menu Utama',
            'permissions' => [
                'test view',
                'barang view',
                'ruangan view',
                'transak view',
                'pelaporan view',
                'laporan view',
                'dashboard view'
            ],
            'menus' => [
                [
                    'title' => 'Data Barang',
                    'icon' => '<i class="bi bi-box"></i>',
                    'route' => '/barangs',
                    'permission' => 'barang view',
                    'permissions' => [],
                    'submenus' => []
                ],
                [
                    'title' => 'Data Ruangan',
                    'icon' => '<i class="bi bi-building"></i>',
                    'route' => '/ruangans',
                    'permission' => 'ruangan view',
                    'permissions' => [],
                    'submenus' => []
                ],
                [
                    'title' => 'Transaksi',
                    'icon' => '<i class="bi bi-receipt"></i>',
                    'route' => '/transaks',
                    'permission' => 'transak view',
                    'permissions' => [],
                    'submenus' => []
                ],
                [
                    'title' => 'Inventaris',
                    'icon' => '<i class="bi bi-archive"></i>',
                    'route' => '/pelaporans',
                    'permission' => 'pelaporan view',
                    'permissions' => [],
                    'submenus' => []
                ],
                [
                    'title' => 'Laporan',
                    'icon' => '<i class="bi bi-bar-chart"></i>',
                    'route' => '/laporans',
                    'permission' => 'laporan view',
                    'permissions' => [],
                    'submenus' => []
                ]
            ]
        ],
        [
            'header' => 'Users',
            'permissions' => [
                'user view',
                'role & permission view',
                'pegawai view'
            ],
            'menus' => [
                [
                    'title' => 'Users',
                    'icon' => '<i class="bi bi-people-fill"></i>',
                    'route' => '/users',
                    'permission' => 'user view',
                    'permissions' => [],
                    'submenus' => []
                ],
                [
                    'title' => 'Roles & permissions',
                    'icon' => '<i class="bi bi-person-check-fill"></i>',
                    'route' => '/roles',
                    'permission' => 'role & permission view',
                    'permissions' => [],
                    'submenus' => []
                ],
                [
                    'title' => 'Pegawai',
                    'icon' => '<i class="bi bi-people-fill"></i>',
                    'route' => '/pegawais',
                    'permission' => 'pegawai view',
                    'permissions' => [],
                    'submenus' => []
                ]
            ]
        ]

    ]
];
