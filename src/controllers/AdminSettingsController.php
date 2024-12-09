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
use skeeks\cms\rbac\CmsManager;

/**
 * @author Semenov Alexander <semenov@skeeks.com>
 */
class AdminSettingsController extends BackendController
{
    public function init()
    {
        $this->name = \Yii::t('skeeks/dbDumper', "Settings");

        $this->generateAccessActions = false;
        $this->permissionName = CmsManager::PERMISSION_ROLE_ADMIN_ACCESS;

        parent::init();
    }

    public function actionIndex()
    {
        return $this->render($this->action->id);
    }

    public function actionRefresh()
    {
        $rr = new RequestResponse();

        if ($rr->isRequestAjaxPost()) {
            \Yii::$app->db->schema->refresh();
            $rr->message = \Yii::t('skeeks/dbDumper', 'The cache is updated successfully');
            $rr->success = true;
            return $rr;
        }
    }
}