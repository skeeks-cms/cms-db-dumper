<?php
/**
 * @author Semenov Alexander <semenov@skeeks.com>
 * @link http://skeeks.com/
 * @copyright 2010 SkeekS (СкикС)
 * @date 08.06.2015
 */
/* @var $this yii\web\View */
/* @var $dbBackupDir \skeeks\sx\Dir */

$db = \Yii::$app->db;
$schema = $db->getSchema();
$schema->refresh();
?>

<?= \skeeks\cms\modules\admin\widgets\GridView::widget([
    'dataProvider'  => $dataProvider,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],

        [
            'attribute' => 'fullName',
            'label' => \Yii::t('skeeks/dbDumper', 'Name'),
        ],

        [
            'attribute' => 'fullName',
            'label' => \Yii::t('skeeks/dbDumper', 'Full name'),
        ],

        [
            'class'         => \yii\grid\DataColumn::className(),
            'label'         => \Yii::t('skeeks/dbDumper','Number of columns'),
            'value' => function(yii\db\TableSchema $model)
            {
                return count($model->columns);
            }
        ],

        [
            'class'         => \yii\grid\DataColumn::className(),
            'attribute'     => 'primaryKey',
            'label'         => \Yii::t('skeeks/dbDumper','Primary keys'),
            'value' => function(yii\db\TableSchema $model)
            {
                return implode(', ', $model->primaryKey);
            }
        ],


        [
            'class'         => \yii\grid\DataColumn::className(),
            'attribute'     => 'foreignKeys',
            'label'         => \Yii::t('skeeks/dbDumper', 'Number of foreign keys'),
            'value' => function(yii\db\TableSchema $model)
            {
                return count($model->foreignKeys);
            }
        ],


        'schemaName',
        'sequenceName'
    ],
]); ?>