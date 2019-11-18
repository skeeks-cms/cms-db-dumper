<?php
return [

    'components' => [
        'dbDumper' => [
            'class' => '\skeeks\cms\dbDumper\DbDumperComponent',
        ],

        'i18n' => [
            'translations' =>
                [
                    'skeeks/dbDumper' => [
                        'class'    => 'yii\i18n\PhpMessageSource',
                        'basePath' => '@skeeks/cms/dbDumper/messages',
                        'fileMap'  => [
                            'skeeks/dbDumper' => 'main.php',
                        ],
                    ],
                ],
        ],

        'cmsAgent' => [
            'commands' => [
                'dbDumper/mysql/dump' => [
                    'class'    => \skeeks\cms\agent\CmsAgent::class,
                    'name'     => ['skeeks/dbDumper', 'Backup Database'],
                    'interval' => 3600 * 24,
                ],
            ],
        ],

        'authManager' => [
            'config' => [
                'roles' => [
                    [
                        'name'  => \skeeks\cms\rbac\CmsManager::ROLE_ADMIN,
                        'child' => [
                            //Есть доступ к системе администрирования
                            'permissions' => [
                                "dbDumper/admin-structure",
                                "dbDumper/admin-settings",
                                "dbDumper/admin-backup",
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ],

    'modules' => [
        'dbDumper' => [
            'class' => '\skeeks\cms\dbDumper\DbDumperModule',
        ],
    ],
];