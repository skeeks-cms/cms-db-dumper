<?php
/**
 * @author Semenov Alexander <semenov@skeeks.com>
 * @link http://skeeks.com/
 * @copyright 2010 SkeekS (�����)
 * @date 19.04.2016
 */

namespace skeeks\cms\dbDumper\controllers;

use skeeks\cms\modules\admin\controllers\AdminController;
use yii\data\ArrayDataProvider;

/**
 * Class AdminStructureController
 * @package skeeks\cms\dbDumper\controllers
 */
class AdminStructureController extends AdminController
{
    public function init()
    {
        $this->name = \Yii::t('skeeks/dbDumper', "The structure of the database");

        parent::init();
    }

    public function actionIndex()
    {
        //print_r(\Yii::$app->db->getSchema()->getTableSchemas());die;
        $dataProvider = new ArrayDataProvider([
            'allModels'  => \Yii::$app->db->getSchema()->getTableSchemas(),
            'sort'       => [
                'attributes' => ['name', 'fullName'],
            ],
            'pagination' => [
                'defaultPageSize' => 20,
            ],
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }
}