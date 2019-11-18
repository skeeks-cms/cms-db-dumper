<?php
return [
    'components' => [
        'backendAdmin' => [
            'menu' => [
                'data' => [
                    'other' => [
                        'items' => [
                            [
                                "name"  => ['skeeks/dbDumper', "Database"],
                                "image" => ['\skeeks\cms\dbDumper\assets\DbDumperAsset', 'icons/bd-arch.png'],
                                "items" => [
                                    [
                                        "name"  => ['skeeks/dbDumper', "The structure of the database"],
                                        "url"   => ["dbDumper/admin-structure"],
                                        "image" => ['\skeeks\cms\dbDumper\assets\DbDumperAsset', 'icons/bd-arch.png'],
                                    ],

                                    [
                                        "name"  => ['skeeks/dbDumper', "Settings"],
                                        "url"   => ["dbDumper/admin-settings"],
                                        "image" => ['\skeeks\cms\dbDumper\assets\DbDumperAsset', 'icons/settings.png'],
                                    ],

                                    [
                                        "name"  => ['skeeks/dbDumper', "Backups"],
                                        "url"   => ["dbDumper/admin-backup"],
                                        "image" => ['\skeeks\cms\dbDumper\assets\DbDumperAsset', 'icons/backup.png'],
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ],
];