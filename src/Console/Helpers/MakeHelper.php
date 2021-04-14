<?php
namespace Gslim\Console\Helpers;

use Exception;
/**
 * Make Helper
 */
class MakeHelper
{

    /**
     * Get array split
     *
     * @param string $className
     * @return array
     */
    public static function getReplacement(string $className):array
    {   
       return preg_split("/(?<=[a-z])(?![a-z])/", $className, -1, PREG_SPLIT_NO_EMPTY);        
    }

    /**
     * Set file Path
     *
     * @param string $className
     * @param string $baseFileName
     * @return void
     */
    public static function generateFilePath(string $className, string $baseFileName)
    {
        $className = str_replace("\\", '/', $className);
        $className = trim($className, '/');
        $className = ucfirst($className);

        if (strpos($className, '-') !== false) {
            $className = array_map(function ($v) {
                $v = ucfirst($v);
                return $v;
            }, explode('-', $className));
            $className = implode('', $className);
        }
        if (strpos($className, '/') !== false) {
            $className = array_map(function ($v) {
                $v = ucfirst($v);
                return $v;
            }, explode('/', $className));
            $className = implode('/', $className);
        }

        $fileName = ROOT_PATH . $baseFileName . DIRECTORY_SEPARATOR;

        if (strpos($className, '/') !== false) {
            $path = substr($className, 0, strrpos($className, '/'));
            $className = substr($className, strrpos($className, '/') + 1);

            $fileName .= $path . DIRECTORY_SEPARATOR;

            $path = str_replace('/', '\\', $path);
            $path = '\\' . $path;
        } else {
            $path = '';
        }
        $fileName .= $className . '.php';
        if (file_exists($fileName)) {
            throw new Exception('class file is exist');
        } else {
            if (!is_dir(dirname($fileName))) {
                mkdir(dirname($fileName), 0777, true);
            }
        }
        return [$className, $path, $fileName];
    }

    /**
     * Set Classname
     *
     * @param string $className
     * @param string $setter
     * @return string
     */
    public static function setClassName(string $className, string $setter) : string
    {
        $className = preg_split("/(?<=[a-z])(?![a-z])/", $className, -1, PREG_SPLIT_NO_EMPTY);
        $className[1] = isset( $className[1] ) ?  $className[1] : $setter;
        $className =  $className[0].$className[1];
        if (strpos($className, $setter) === false) {
            $className = $className.$setter;
        }
        return $className;
    }
}
