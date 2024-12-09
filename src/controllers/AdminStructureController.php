<?php
/**
 * @link https://cms.skeeks.com/
 * @copyright Copyright (c) 2010 SkeekS
 * @license https://cms.skeeks.com/license/
 * @author Semenov Alexander <semenov@skeeks.com>
 */

namespace skeeks\cms\dbDumper\controllers;

use skeeks\cms\backend\BackendController;
use skeeks\cms\rbac\CmsManager;
use yii\data\ArrayDataProvider;

/**
 * @author Semenov Alexander <semenov@skeeks.com>
 */
class AdminStructureController extends BackendController
{
    public function init()
    {
        $this->name = \Yii::t('skeeks/dbDumper', "The structure of the database");

        $this->generateAccessActions = false;
        $this->permissionName = CmsManager::PERMISSION_ROOT_ACCESS;

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