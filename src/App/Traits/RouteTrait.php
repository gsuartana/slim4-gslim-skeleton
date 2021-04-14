<?php
declare(strict_types=1);

namespace Gslim\App\Traits;
/**
 * Application configuration
 *
 * Trait ConfigTrait
 * @package Gslim\App\Traits
 * @author gede.suartana <gede.suartana@outlook.com>
 */
trait RouteTrait
{

    /**
     * Provide application project directory
     *
     * @return string
     */
    public function getConfigDir(): string
    {
        return dirname(__DIR__ )."/Routes/";
    }

    /**
     * Provide application configuration file path
     *
     * @param string $filename
     * @return string
     */
    public function getConfigFile(string $filename): string
    {
        return $this->getConfigDir().'/'.$filename.'.php';
    }

    /**
     * Require application configuration file
     *
     * @param string $filename
     * @return mixed
     */
    public function loadConfig(string $filename )
    {
        $configFile = $this->getConfigFile($filename);
        return require $configFile;

    }


}