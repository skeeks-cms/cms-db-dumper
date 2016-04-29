<?php
/**
 * @author Semenov Alexander <semenov@skeeks.com>
 * @link http://skeeks.com/
 * @copyright 2010 SkeekS (СкикС)
 * @date 08.06.2015
 */
/* @var $this yii\web\View */
/* @var $dbBackupDir \skeeks\sx\Dir */

$dbBackupDir = new \skeeks\sx\Dir(\Yii::$app->dbDumper->backupDirPath);
$backend = \yii\helpers\Url::to(['dump']);


?>



<div id="sx-backups">
    <?



    $this->registerJs(<<<JS
(function(sx, $, _)
{
    sx.classes.DbDumper = sx.classes.Component.extend({

        _onDomReady: function()
        {
            var self = this;

            $(".sx-btn-make").on('click', function()
            {
                self.make();
                return false;
            });
        },

        make: function()
        {
            var ajax = sx.ajax.preparePostQuery(this.get("backend"));
            var rr = new sx.classes.AjaxHandlerStandartRespose(ajax);
            rr.bind('error', function(e, data)
            {
                $.pjax.reload('#sx-backups', {});
                return false;
            });

            rr.bind('success', function(e, data)
            {
                $.pjax.reload('#sx-backups', {});
                return false;
            });

            ajax.execute();
        }
    });


    sx.DbDumper = new sx.classes.DbDumper({
        'backend' : '{$backend}'
    });

})(sx, sx.$, sx._);
JS
);

    ?>
    <?= \yii\helpers\Html::a("<i class=\"glyphicon glyphicon-save\"></i> ". \Yii::t('skeeks/dbDumper', 'Make a backup'), "#", [
        'class'         => 'btn btn-primary sx-btn-make',
    ]); ?>

    <br />
    <br />
    <? if ($dbBackupDir->isExist()) : ?>
        <?= \skeeks\cms\modules\admin\widgets\GridView::widget([
                'dataProvider'  => new \yii\data\ArrayDataProvider([
                    'allModels' => $dbBackupDir->findFiles()
                ]),
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    [
                        'class'         => \yii\grid\DataColumn::className(),
                        'value' => function(\skeeks\sx\File $model)
                        {
                            return $model->getBaseName();
                        }
                    ],

                    [
                        'class'         => \yii\grid\DataColumn::className(),
                        'value' => function(\skeeks\sx\File $model)
                        {
                            return $model->size()->formatedSize();
                        }
                    ],

                ]
            ]);
        ?>

        <?
            echo \mihaildev\elfinder\ElFinder::widget([
                'language'         => \Yii::$app->language,
                'controller'       => 'cms/elfinder-full', // вставляем название контроллера, по умолчанию равен elfinder
                'path'           => $dbBackupDir->getPath(),
                //'filter'           => 'image',    // фильтр файлов, можно задать массив фильтров https://github.com/Studio-42/elFinder/wiki/Client-configuration-options#wiki-onlyMimes
                'callbackFunction' => new \yii\web\JsExpression('function(file, id){}'), // id - id виджета
                'frameOptions' => [
                    'style' => 'width: 100%; height: 800px;'
                ]
            ]);
        ?>
    <? else: ?>
        <p><?=\Yii::t('skeeks/dbDumper','Directory with files of backups database is not found.')?></p>
    <? endif; ?>
</div>
