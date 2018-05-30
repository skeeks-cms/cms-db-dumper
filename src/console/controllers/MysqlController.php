<?php
/**
 * @author Semenov Alexander <semenov@skeeks.com>
 * @link http://skeeks.com/
 * @copyright 2010 SkeekS (СкикС)
 * @date 18.03.2016
 */

namespace skeeks\cms\dbDumper\console\controllers;

use yii\helpers\Console;

/**
 * Working with the mysql database
 *
 * Class DbController
 * @package skeeks\cms\dbDumper\console\controllers
 */
class MysqlController extends \yii\console\Controller
{
    public $defaultAction = "dump";

    /**
     * Restore from the file dump
     * @param null $fileName The path to the dump file
     */
    public function actionRestore($fileName = null)
    {
        try {
            $this->stdout(\Yii::t('skeeks/dbDumper', "The installation process is running the database")."\n");
            \Yii::$app->dbDumper->restore($fileName);
            $this->stdout(\Yii::t('skeeks/dbDumper', "Dump successfully installed")."\n", Console::FG_GREEN);
        } catch (\Exception $e) {
            $this->stdout(\Yii::t('skeeks/dbDumper',
                    "In the process of restoring the dump occurred error").": {$e->getMessage()}\n", Console::FG_RED);
        }
    }

    /**
     * Creating a dump
     */
    public function actionDump()
    {
        try {
            $result = \Yii::$app->dbDumper->dump();
            $this->stdout(\Yii::t('skeeks/dbDumper', "Dump the database was created successfully").": {$result}\n",
                Console::FG_GREEN);
            $removed = \Yii::$app->dbDumper->clear();
            if ($removed > 0) {
                $this->stdout(\Yii::t('skeeks/dbDumper', "Removed old dumps").": {$removed}\n", Console::FG_GREEN);
            }

        } catch (\Exception $e) {
            $this->stdout(\Yii::t('skeeks/dbDumper', "During the dump error occurred").": {$e->getMessage()}\n",
                Console::FG_RED);
        }
    }

}