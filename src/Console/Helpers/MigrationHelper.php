<?php
namespace Gslim\Console\Helpers;

use Illuminate\Support\Facades\DB;

class MigrationHelper
{
    /**
     * Get the root directory path of the data migration file
     *
     * @return string
     */
    public static function migrateFileBasePath(): string
    {
        return ROOT_PATH . 'src/Console' . DIRECTORY_SEPARATOR . 'Migrations';
    }

    /**
     * Get the migration batch
     *
     * @return int
     */
    public static function getCurrentBatch(): int
    {
        $infoRs = DB::table('migrations')->select('id', 'batch')
            ->orderBy('id', 'desc')->first();
        if (!isset($infoRs->id)) {
            return 1;
        } else {
            return $infoRs->batch + 1;
        }
    }

    /**
     * The migration file name is converted to the class name
     *
     * @param string $fileName migration file
     * @return string class name
     */
    public static function getMigrateFileClass(string $fileName): string
    {
        $tmp = substr($fileName, 0, 4);
        if (!is_numeric($tmp)) {
            return '';
        }
        $fileName = substr($fileName, 5);
        $tmp = substr($fileName, 0, 2);
        if (!is_numeric($tmp)) {
            return '';
        }
        $fileName = substr($fileName, 3);
        $tmp = substr($fileName, 0, 2);
        if (!is_numeric($tmp)) {
            return '';
        }
        $fileName = substr($fileName, 3);
        $tmp = substr($fileName, 0, 6);
        if (!is_numeric($tmp)) {
            return '';
        }
        $fileName = substr($fileName, 7);
        $fileName = array_map(function ($v) {
            return ucfirst($v);
        }, explode('_', $fileName));

        $fileName = implode('', $fileName);
        return $fileName;
    }

    /**
     * The name of the migration table is converted to a file name
     *
      * @param string $tableName migration table name
      * @return string file path and file name
      */
    public static function tablenameConvertFilename(string $tableName): string
    {
        $fileName = self::migrateFileBasePath() . DIRECTORY_SEPARATOR;
        $fileName .= date('Y_m_d_His_') . $tableName . '.php';
        return $fileName;
    }
}
