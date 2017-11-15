<?php
/**
 * @author Semenov Alexander <semenov@skeeks.com>
 * @link http://skeeks.com/
 * @copyright 2010 SkeekS (СкикС)
 * @date 08.06.2015
 */
/* @var $this yii\web\View */
/* @var $dbBackupDir \skeeks\sx\Dir */

$backend = \yii\helpers\Url::to(['refresh']);
$this->registerJs(<<<JS
(function(sx, $, _)
{
    sx.classes.RefreshDb = sx.classes.Component.extend({

        _onDomReady: function()
        {
            var self = this;

            $(".sx-btn-refresh").on('click', function()
            {
                self.refresh();
                return false;
            });
        },

        refresh: function()
        {
            var Ajax = sx.ajax.preparePostQuery(this.get('backend'));
            var Handler = new sx.classes.AjaxHandlerStandartRespose(Ajax);
            Ajax.execute();
        }
    });
    sx.RefreshDb = new sx.classes.RefreshDb({
        'backend' : '{$backend}'
    });
})(sx, sx.$, sx._);
JS
)
?>
<?= \yii\helpers\Html::a("<i class=\"glyphicon glyphicon-retweet\"></i> " . \Yii::t('skeeks/dbDumper',
        'Refresh cache table structure'), "#", [
    'class' => 'btn btn-primary sx-btn-refresh',
    'data-method' => 'post'
]) ?>

    <br/>
    <br/>
<?= \skeeks\cms\modules\admin\widgets\GridView::widget([
    'dataProvider' => new \yii\data\ArrayDataProvider([
        'allModels' =>
            [
                [
                    'name' => \Yii::t('skeeks/dbDumper', 'Cache table structure'),
                    'value' => \Yii::$app->db->enableSchemaCache ? "Y" : "N"
                ],

                [
                    'name' => \Yii::t('skeeks/dbDumper', 'Cache query'),
                    'value' => \Yii::$app->db->enableSchemaCache ? "Y" : "N"
                ]
            ]
    ]),
    'columns' => [
        [
            'attribute' => 'name',
            'label' => \Yii::t('skeeks/dbDumper', 'Name setting'),
        ],

        [
            'class' => \skeeks\cms\grid\BooleanColumn::className(),
            'attribute' => 'value',
        ]
    ]
]);
?>