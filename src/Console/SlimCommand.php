<?php

namespace Gslim\Console;

use Dotenv\Dotenv as Dotenv;
use Symfony\Component\Console\Application as Application;
use Illuminate\Database\Capsule\Manager as Manager;
use Illuminate\Support\Facades\DB;
use Gslim\Console\Services\Creation\MakeCommand;
use Gslim\Console\Services\Creation\MakeService;
use Gslim\Console\Services\Creation\MakeController;
use Gslim\Console\Services\Creation\MakeMigration;
use Gslim\Console\Services\MigrationExecution;
use Gslim\Console\Services\MigrationRollback;
use Gslim\Console\Services\CronJobScheduler;
use Gslim\Console\Services\Creation\MakeEntity;
use Gslim\Console\Services\Creation\MakeTrait;
use Gslim\Console\Services\Creation\MakeMiddleware;
use Gslim\Console\Services\Creation\MakeException;
use ReflectionClass;


/**
 * Class SlimCommandApp
 * @package Console
 * @author Gede Suartana <gede.suartana@outlook.com>
 */
class SlimCommand extends Application
{
    /**
     * Define default command name
     *
     * @var string
     */
    protected $name = 'Slim Command Management Console';
    /**
     * Define default version
     *
     * @var string
     */
    protected $version = '1.0';

    /**
     * SlimCommandApp constructor.
     *
     * @param string|null $name
     * @param string|null $version
     */
    public function __construct()
    {
          
        parent::__construct($this->name, $this->version);
        $this->commands();
        $this->getEnvironment();
        $this->setDatabaseConnection();
    }

    /**
     * Provide available commands
     */
    protected function commands()
    {
        // add available command
        $this->add(new MakeCommand());
        $this->add(new MakeService());
        $this->add(new MakeController());
        $this->add(new MakeMigration());
        $this->add(new MigrationExecution());
        $this->add(new MigrationRollback());
        $this->add(new CronJobScheduler());
        $this->add(new MakeEntity());
        $this->add(new MakeTrait());
        $this->add(new MakeMiddleware());
        $this->add(new MakeException());

        $commands = $this->availableCommand();
        foreach ($commands as $k => $v) {
            $commands[$k] = new $v;
        }
        if (isset($commands[0])) {
            $this->addCommands($commands);
        }
    }

    /**
     * Provide available commands
     *
     * @return array
     * @throws ReflectionException
     */
    private function availableCommand(): array
    {
        $classRs = $this->getAllFilesClass();
        foreach ($classRs as $k => $v) { ;
            $ref = new \ReflectionClass($v);
            $parentClass = $ref->getParentClass()->getName();
            if ($parentClass !== 'Symfony\Component\Console\Command\Command') {
                unset($classRs[$k]);
                continue;
            }
        }
        return array_values($classRs);
    }

    /**
     * Providing class files
     *
     * @param string $path
     * @return array
     */
    private function getAllFilesClass($path = ''): array
    {
        if ($path == '') {
            $path = __DIR__ .'/Command';
        }    
        $fileRs = scandir($path);       
        $return = array();
        foreach ($fileRs as $v) {
            if ($v == '.' || $v == '..') {
                continue;
            }
            $v = $path . DIRECTORY_SEPARATOR . $v;
            $dir = __DIR__;
            $v = str_replace($dir, "Gslim\Console", $v);          
            if (is_dir($v)) {               
                $return = array_merge($return, $this->getAllFilesClass($v));
            } else {
                $extension = strtolower(pathinfo($v, PATHINFO_EXTENSION));
                if ($extension !== 'php') {
                    continue;
                }
                $class = str_replace(__DIR__ . 'Console', __DIR__.'Console', $v);
                $class = str_replace('.php', '', $class);
                $return[] = str_replace('/', '\\', $class);
            }
        }
        return $return;
    }

    /**
     * Set environment config file .env
     */
    private function getEnvironment()
    {
        // Set path environment file
        $configPath = "src/Config/.env";
        $envPath = ROOT_PATH.$configPath;
        
        if(file_exists($envPath)) {
            //create unsafe immutable env file
            $dotenv = Dotenv::createUnsafeImmutable(ROOT_PATH, $configPath);
            $dotenv->load();
            // set glogal environment
        }else {
            echo "Missing environment file, please check the .env file";
            exit;
        }
    }

    /**
     * Introduce DB facade class
     */
    protected function setDatabaseConnection()
    {
        if (!isset($GLOBALS['db'])) {

            $GLOBALS['db'] = new Manager();
            $GLOBALS['db']->addConnection($this->getDbConf());
            $GLOBALS['db']->setAsGlobal();
            $GLOBALS['db']->bootEloquent();

           DB::setFacadeApplication([
                'db' => $GLOBALS['db']->getDatabaseManager(),
            ]);
        }
    }

    /**
     * Get Database configuration
     *
     * @return array
     */
    protected function getDbConf()
    {
        
        $dataBase = [
            'driver' => getenv('DB_CONNECTION') ,
            'host' => getenv('DB_HOST'),
            'port' => getenv('DB_PORT'),
            'database' => getenv('DB_DATABASE'),
            'username' => getenv('DB_USERNAME'),
            'password' => getenv('DB_PASSWORD'),
            'charset' => getenv('DB_CHARSET'),
            'collation' => getenv('DB_COLLATION'),
            'prefix' => getenv('DB_PREFIX'),
        ];

        return $dataBase;
    }

}