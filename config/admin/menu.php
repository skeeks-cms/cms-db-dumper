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
                "label"     => \Yii::t('skeeks/dbDumper', "Database"),
                "img"       => ['\skeeks\cms\dbDumper\assets\DbDumperAsset', 'bd-arch.png'],
                "items"     =>
                [
                    [
                        "label"     => \Yii::t('skeeks/dbDumper', "Database"),
                        "url"       => ["dbDumper/db"],
                        "img"       => ['\skeeks\cms\dbDumper\assets\DbDumperAsset', 'bd-arch.png'],
                    ],
                ],
            ],
        ]
    ]
];