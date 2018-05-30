<?php
/**
 * @author Semenov Alexander <semenov@skeeks.com>
 * @link http://skeeks.com/
 * @copyright 2010 SkeekS (СкикС)
 * @date 12.03.2015
 */
return
    [
        'other' =>
            [
                'items' =>
                    [
                        [
                            "label" => \Yii::t('skeeks/dbDumper', "Database"),
                            "img"   => ['\skeeks\cms\dbDumper\assets\DbDumperAsset', 'icons/bd-arch.png'],
                            "items" =>
                                [
                                    [
                                        "label" => \Yii::t('skeeks/dbDumper', "The structure of the database"),
                                        "url"   => ["dbDumper/admin-structure"],
                                        "img"   => ['\skeeks\cms\dbDumper\assets\DbDumperAsset', 'icons/bd-arch.png'],
                                    ],

                                    [
                                        "label" => \Yii::t('skeeks/dbDumper', "Settings"),
                                        "url"   => ["dbDumper/admin-settings"],
                                        "img"   => ['\skeeks\cms\dbDumper\assets\DbDumperAsset', 'icons/settings.png'],
                                    ],

                                    [
                                        "label" => \Yii::t('skeeks/dbDumper', "Backups"),
                                        "url"   => ["dbDumper/admin-backup"],
                                        "img"   => ['\skeeks\cms\dbDumper\assets\DbDumperAsset', 'icons/backup.png'],
                                    ],
                                ],
                        ],
                    ],
            ],
    ];