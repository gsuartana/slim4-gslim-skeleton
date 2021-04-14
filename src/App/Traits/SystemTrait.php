<?php

namespace Gslim\App\Traits;

use Dotenv\Dotenv as Dotenv;
use Exception;
/**
 * Application configuration
 *
 * Trait ConfigTrait
 * @package Gslim\App\Traits
 */
trait SystemTrait
{

    /**
     * @var string
     */
    protected $environment;

    /**
     * Set application directory
     *
     * @var string
     */
    protected $appsDir;


    /**
     * @var string
     */
    protected $projectDir;

    /**
     * Provide application project directory
     *
     * @return string
     */
    public function getSysConfigDir(string $confPath): string
    {        
        return ROOT_PATH."src/".$confPath;
    }

    /**
     * Provide application configuration file path
     *
     * @param string $filename
     * @return string
     */
    public function getsysConfigFile(string $confPath, string $filename): string
    {
        return $this->getSysConfigDir($confPath).'/'.$filename.'.php';
    }

    /**
     * Require application configuration file
     *
     * @param string $filename
     * @return mixed
     */
    public function loadSysConfig(string $confPath , string $filename )
    {   
        $configFile = $this->getsysConfigFile($confPath, $filename);
        return require $configFile;

    }
 
    /**
     * Provide cache directory
     *
     * @return string
     */
    public function getCacheDir(): string
    {
        return $this->getAppsDir().'/storage/cache/'.$this->getEnvironment();
    }

    /**
     * Provide configuration directory
     *
     * @return string
     */
    public function getConfigurationDir(): string
    {
        return $this->getAppsDir().'/Bootstrap';
    }

    /**
     * Get an environment name
     *
     * @return string
     */
    public function getEnvironment(): string
    {
        return $this->environment;
    }

    /**
     * Get logs directory
     *
     * @return string
     */
    public function getLogsDir(): string
    {
        return $this->getAppsDir().'/storage/logs';
    }

    /**
     * Get application directory
     *
     * @return string
     */
    public function getAppsDir(): string
    {
        if (!$this->appsDir) {
            $this->projectDir = ROOT_PATH."src";
        }

        return $this->projectDir;
    }

    /**
     * Get configuration file
     *
     * @param string $filename
     * @return string
     */
    protected function getConfigFilePath(string $filename): string
    {
        return $this->getConfigurationDir().'/'.$filename.'.php';
    }

    /**
     * Require configuration file
     *
     *
     * @param string $filename
     * @return mixed
     */
    protected function load(string $filename)
    {
        return require $this->getConfigFilePath($filename);
    }

    public function isSessionStarted() 
    {
        if ( php_sapi_name() === 'cli' )
            return false;
    
        return version_compare( phpversion(), '5.4.0', '>=' )
            ? session_status() === PHP_SESSION_ACTIVE
            : session_id() !== '';
    }
  

    /**
     * Set environment config file .env
     *
     * @return void
     */
    private function setEnvironment(): void
    {
        // Set path environment file
        $configPath = "/Config/.env";
        $envPath = $this->getAppsDir().$configPath;     
        if(!file_exists($envPath)) {
            // Set source and destination files
            $settingFile = ".env.example";
            $sourceFile = $this->getAppsDir()."/Config/{$settingFile}";
            $destFile = $envPath ;
            // Copy from the environment file to the env file
            copy( $sourceFile, $destFile);
        }

        if(file_exists($envPath)) {
            try{
                $dotenv = Dotenv::createUnsafeImmutable(ROOT_PATH, "src/{$configPath}");
                $dotenv->load();
            }catch(Exception $e){
                dump($e->getMessage()); 
                exit;
            }
        }

    }


}