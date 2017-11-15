<?php
/**
 * @author Semenov Alexander <semenov@skeeks.com>
 * @link http://skeeks.com/
 * @copyright 2010 SkeekS (СкикС)
 * @date 28.02.2017
 */

namespace skeeks\cms\dbDumper\controllers;

use skeeks\cms\helpers\RequestResponse;
use skeeks\cms\modules\admin\actions\AdminAction;
use skeeks\cms\modules\admin\controllers\AdminController;
use yii\data\ArrayDataProvider;
use yii\web\Response;

/**
 * Class AdminBackupController
 * @package skeeks\cms\dbDumper\controllers
 */
class AdminBackupController extends AdminController
{
    public function init()
    {
        $this->name = \Yii::t('skeeks/dbDumper', "Backups");

        parent::init();
    }

    public function actionIndex()
    {
        return $this->render($this->action->id);
    }

    public function actionDump()
    {
        $rr = new RequestResponse();

        if ($rr->isRequestAjaxPost()) {
            try {
                ob_start();
                \Yii::$app->dbDumper->dump();
                $result = ob_get_clean();


                $rr->success = true;
                $rr->message = \Yii::t('skeeks/dbDumper', "A copy created successfully");
                $rr->data = [
                    'result' => $result
                ];

            } catch (\Exception $e) {
                $rr->success = false;
                $rr->message = $e->getMessage();
            }

            return $rr;
        }

        return $rr;
    }
}