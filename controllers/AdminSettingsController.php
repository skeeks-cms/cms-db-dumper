<?php
/**
 * @author Semenov Alexander <semenov@skeeks.com>
 * @link http://skeeks.com/
 * @copyright 2010 SkeekS (ÑêèêÑ)
 * @date 19.04.2016
 */
namespace skeeks\cms\dbDumper\controllers;
use skeeks\cms\helpers\RequestResponse;
use skeeks\cms\modules\admin\actions\AdminAction;
use skeeks\cms\modules\admin\controllers\AdminController;
use yii\data\ArrayDataProvider;
use yii\web\Response;

/**
 * Class AdminSettingsController
 * @package skeeks\cms\dbDumper\controllers
 */
class AdminSettingsController extends AdminController
{
    public function init()
    {
        $this->name = \Yii::t('skeeks/dbDumper',"Settings");

        parent::init();
    }

    public function actionIndex()
    {
        return $this->render($this->action->id);
    }

    public function actionRefresh()
    {
        $rr = new RequestResponse();

        if ($rr->isRequestAjaxPost())
        {
            \Yii::$app->db->schema->refresh();
            $rr->message = \Yii::t('skeeks/dbDumper', 'The cache is updated successfully');
            $rr->success = true;
            return $rr;
        }
    }
}