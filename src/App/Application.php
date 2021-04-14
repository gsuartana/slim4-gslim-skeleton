<?php

namespace Gslim\App;

use Gslim\App\Traits\ApplicationTrait;
use Gslim\App\Traits\SystemTrait;
use DI\ContainerBuilder;
use Slim\App;
use Slim\Factory\AppFactory;
use Slim\Handlers\Strategies\RequestResponseArgs;
use Gslim\App\Services\ErrorBaseServices;
use Gslim\App\Helpers\Logit;
use Gslim\App\Traits\RouteTrait;

/**
 * Main slim application
 *
 * Class Application
 * @package App
 * @author gede.suartana <gede.suartana@outlook.com>
 */
final class Application extends App
{
    use RouteTrait, 
        SystemTrait;
    /**
     * Application constructor.
     */
    public function __construct()
    {          
        if(!$this->isSessionStarted()){
            session_start();
        }
        //set environment file
        $this->setEnvironment();
        //set an environment 
        $this->getAppsDir();
        //set container
        $container = new ContainerBuilder();
        //set environment
        $this->loadSysConfig("Config", 'settings')($container);
        $this->loadSysConfig("Config", 'errordetails')($container);
        $this->load('Dependencies')($this, $container);
        //set container build
        $containerBuild = $container->build();
        $settings =  $containerBuild->get("settings");  
        $this->environment = $settings["env"]; 
        //call parent construct
        parent::__construct(AppFactory::determineResponseFactory(), $containerBuild);
        //collecting routes
        $this->getRouteCollector()->setDefaultInvocationStrategy(new RequestResponseArgs());
        //load Middleware
        $this->load('Middleware')($this, $settings);
        //application routes
        $this->loadConfig( 'Routes')($this);
    }
}