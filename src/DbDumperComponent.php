<?php
/**
 * @link https://cms.skeeks.com/
 * @copyright Copyright (c) 2010 SkeekS
 * @license https://cms.skeeks.com/license/
 * @author Semenov Alexander <semenov@skeeks.com>
 */

namespace skeeks\cms\dbDumper;

use Ifsnop\Mysqldump\Mysqldump;
use skeeks\cms\base\Component;
use skeeks\cms\dbDumper\assets\DbDumperAsset;
use yii\base\InvalidArgumentException;
use yii\db\Connection;
use yii\helpers\ArrayHelper;
use yii\helpers\FileHelper;

/**
 * @author Semenov Alexander <semenov@skeeks.com>
 */
class DbDumperComponent extends Component
{
    /**
     * @var string
     */
    public $backupDirPath = '';

    /**
     * @var string
     */
    public $db = "db";

    /**
     * @var int Number of backup files. The old will be deleted
     */
    public $totalBackups = 5;

    /**
     * @var Connection
     */
    public $connection;

    /**
     * Можно задать название и описание компонента
     * @return array
     */
    static public function descriptorConfig()
    {
        return array_merge(parent::descriptorConfig(), [
            'name' => "Сохранение базы данных",
            'image' => [
                DbDumperAsset::class, 'icons/mysql-dump.jpg'
            ],
        ]);
    }


    public function init()
    {
        if (!$this->backupDirPath) {
            $this->backupDirPath = ROOT_DIR."/backup/db";
        }

        parent::init();
    }

    /**
     * @return int
     */
    public function clear()
    {
        $this->_ensure();

        if (!dir($this->backupDirPath)) {
            return 0;
        }

        $filesObjects = [];
        $files = \yii\helpers\FileHelper::findFiles($this->backupDirPath);
        foreach ($files as $filePath) {
            $filesObjects[] = [
                'path'      => $filePath,
                'filemtime' => filemtime($filePath),
            ];
        }

        if (!$filesObjects) {
            return 0;
        }

        \yii\helpers\ArrayHelper::multisort($filesObjects, 'filemtime', SORT_DESC);

        $counter = 0;
        $removed = 0;
        foreach ($filesObjects as $fileData) {
            $counter++;
            if ($counter > $this->totalBackups) {
                $file = ArrayHelper::getValue($fileData, 'path');
                if (file_exists($file)) {
                    if (@unlink($file)) {
                        $removed++;
                    }
                }
            }
        }

        return $removed;
    }


    protected function _ensure()
    {
        if (isset(\Yii::$app->{$this->db})) {
            $this->connection = \Yii::$app->{$this->db};
        }

        if (!$this->connection || !$this->connection instanceof Connection) {
            throw new InvalidArgumentException("Incorrect connection to the database");
        }

        if (!is_dir($this->backupDirPath)) {
            FileHelper::createDirectory($this->backupDirPath);
        }
    }


    /**
     *
     * Создание бэкап файла базы данных
     *
     * @return string
     * @throws \Exception
     * @throws \yii\base\Exception
     */
    public function dump()
    {
        $this->_ensure();

        if (!is_dir($this->backupDirPath)) {
            FileHelper::createDirectory($this->backupDirPath);
        }

        if (!is_dir($this->backupDirPath)) {
            throw new \InvalidArgumentException(\Yii::t('skeeks/dbDumper',
                    "Folder to store the backup file is not found and could not be created").": ".$this->backupDirPath);
        }

        $filePath = $this->backupDirPath."/db__".date('Y-m-d_H-i-s').".sql.gz";

        $dump = new Mysqldump($this->connection->dsn, $this->connection->username, $this->connection->password, [
            'compress' => Mysqldump::GZIP
        ]);

        $dump->setTableLimits(array(
            'log_db_target' => 1,
            'cms_session' => 1,
        ));

        $dump->start($filePath);

        return $filePath;
    }
    /**
     * @return string
     */
    public function restore($fileDumpSql = null)
    {
        $this->_ensure();

        ini_set("memory_limit", "2048M");
        ignore_user_abort(true);
        set_time_limit(0);

        $filePath = null;

        //Если файл дампа для востановления не указан идет поиск первого файла в папке с бэкапами базы
        if (!$fileDumpSql) {
            if (!is_dir($this->backupDirPath)) {
                throw new \InvalidArgumentException(\Yii::t('skeeks/dbDumper',
                        "Do not locate the folder with the backup database").": ".$this->backupDirPath);
            }

            if (!$files = FileHelper::findFiles($this->backupDirPath)) {
                throw new \InvalidArgumentException(\Yii::t('skeeks/dbDumper',
                        "Backup files found in a dir").": ".$this->backupDirPath);
            }

            $filePath = $files[0];

        } else {
            $filePath = \Yii::getAlias($fileDumpSql);
        }

        if (!file_exists($filePath) || !is_readable($filePath)) {
            throw new \InvalidArgumentException(\Yii::t('skeeks/dbDumper', "Dump file is not found"));
        }

        $sql = file_get_contents($filePath);

        if (!$sql) {
            throw new \InvalidArgumentException(\Yii::t('skeeks/dbDumper', "Sql query is invalid"));
        }

        \Yii::$app->db->createCommand($sql)->execute();
    }
}