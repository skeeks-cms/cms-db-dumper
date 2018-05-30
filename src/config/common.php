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
    ],

    'modules' => [
        'dbDumper' => [
            'class' => '\skeeks\cms\dbDumper\DbDumperModule',
        ],
    ],
];