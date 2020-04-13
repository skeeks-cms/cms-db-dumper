<?php
/**
 * @link https://cms.skeeks.com/
 * @copyright Copyright (c) 2010 SkeekS
 * @license https://cms.skeeks.com/license/
 * @author Semenov Alexander <semenov@skeeks.com>
 */
namespace skeeks\cms\dbDumper\controllers;

use skeeks\cms\backend\BackendController;
use skeeks\cms\helpers\RequestResponse;
use skeeks\cms\modules\admin\controllers\AdminController;

/**
 * @author Semenov Alexander <semenov@skeeks.com>
 */
class AdminBackupController extends BackendController
{
    public function init()
    {
        $this->name = \Yii::t('skeeks/dbDumper', "Backups");


        $this->generateAccessActions = false;
        $this->accessCallback = function () {
            if (!\Yii::$app->cms->site->is_default) {
                return false;
            }
            return \Yii::$app->user->can($this->uniqueId);
        };


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
                    'result' => $result,
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