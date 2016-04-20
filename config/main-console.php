<?php
return [

    'components' =>
    [
        'dbDumper' => [
            'class'         => 'skeeks\cms\dbDumper\DbDumperComponent',
        ],

        'i18n' => [
            'translations' =>
            [
                'skeeks/dbDumper' => [
                    'class'             => 'yii\i18n\PhpMessageSource',
                    'basePath'          => '@skeeks/cms/dbDumper/messages',
                    'fileMap' => [
                        'skeeks/dbDumper' => 'main.php',
                    ],
                ]
            ]
        ],
    ],

    'modules' =>
    [
        'dbDumper' => [
            'class'                         => 'skeeks\cms\dbDumper\DbDumperModule',
            'controllerNamespace'           => 'skeeks\cms\dbDumper\console\controllers',
        ]
    ]
];