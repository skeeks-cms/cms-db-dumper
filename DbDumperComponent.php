<?php
/**
 * @author Semenov Alexander <semenov@skeeks.com>
 * @link http://skeeks.com/
 * @copyright 2010 SkeekS (СкикС)
 * @date 19.04.2016
 */
namespace skeeks\cms\dbDumper;
use Ifsnop\Mysqldump\Mysqldump;
use yii\base\Component;
use yii\db\Connection;
use yii\helpers\FileHelper;

/**
 * Class DbDumperComponent
 * @package skeeks\cms\dbDumper
 */
class DbDumperComponent extends Component
{
    /**
     * @var string
     */
    public $backupDirPath = ROOT_DIR . "/backup/db";

    /**
     * @var string
     */
    public $db        = "db";

    /**
     * @var Connection
     */
    public $connection;

    public function init()
    {
        parent::init();

        /**
         * TODO: добавить проверки
         */
        $this->connection = \Yii::$app->{$this->db};

        if (!$this->connection || !$this->connection instanceof Connection)
        {
            throw new \InvalidArgumentException("Некорректный коннект к базе данных");
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
        if (!is_dir($this->backupDirPath))
        {
            FileHelper::createDirectory($this->backupDirPath);
        }

        if (!is_dir($this->backupDirPath))
        {
            throw new \InvalidArgumentException("Folder to store the backup file is not found and could not be created: " . $this->backupDirPath);
        }

        $filePath   = $this->backupDirPath . "/db__" . date('Y-m-d_H:i:s') . ".sql";

        $dump = new Mysqldump($this->connection->dsn, $this->connection->username, $this->connection->password);
        $dump->start($filePath);

        return $filePath;
    }


    /**
     * @return string
     */
    public function restore($fileDumpSql = null)
    {
        ignore_user_abort(true);
        set_time_limit(0);

        $filePath = null;

        //Если файл дампа для востановления не указан идет поиск первого файла в папке с бэкапами базы
        if (!$fileDumpSql)
        {
            if (!is_dir($this->backupDirPath))
            {
                throw new \InvalidArgumentException("Do not locate the folder with the backup database: " . $this->backupDirPath);
            }

            if (!$files = FileHelper::findFiles($this->backupDirPath))
            {
                throw new \InvalidArgumentException("Backup files found in a dir: " . $this->backupDirPath);
            }

            $filePath = $files[0];

        } else
        {
            $filePath = \Yii::getAlias($fileDumpSql);
        }

        if (!file_exists($filePath) || !is_readable($filePath))
        {
            throw new \InvalidArgumentException("Dump file is not found");
        }

        $sql = file_get_contents($filePath);

        if (!$sql)
        {
            throw new \InvalidArgumentException("Sql query is invalid");
        }

        \Yii::$app->db->createCommand($sql)->execute();

    }
}