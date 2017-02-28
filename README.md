Database dumper for SkeekS CMS
===================================

Installation
------------

The preferred way to install this extension is through [composer](https://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist skeeks/cms-db-dumper "*"
```

or add

```
"skeeks/cms-db-dumper": "*"
```

Configuration app
----------

```php

'components' =>
[
    'dbDumper' => [
        'class'         => '\skeeks\cms\dbDumper\DbDumperComponent',
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
        'class'         => '\skeeks\cms\dbDumper\DbDumperModule',
    ]
]

```

##Links
* [Web site](https://en.cms.skeeks.com)
* [Web site (rus)](https://cms.skeeks.com)
* [Author](https://skeeks.com)


___

> [![skeeks!](https://gravatar.com/userimage/74431132/13d04d83218593564422770b616e5622.jpg)](https://skeeks.com)  
<i>SkeekS CMS (Yii2) — quickly, easily and effectively!</i>  
[skeeks.com](https://skeeks.com) | [cms.skeeks.com](https://cms.skeeks.com)


