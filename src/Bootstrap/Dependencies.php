<?php

use Gslim\App\Application;
use DI\ContainerBuilder;
use Psr\Container\ContainerInterface;
use Illuminate\Database\Capsule\Manager as Capsule;
use Doctrine\ORM\EntityManager as EntityManager;
use Doctrine\ORM\Tools\Setup;
use Gslim\App\Helpers\Session as HelpersSession;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Monolog\Processor\UidProcessor;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\Session\Storage\MockArraySessionStorage;
use Symfony\Component\HttpFoundation\Session\Storage\NativeSessionStorage;
use Gslim\App\Helpers\SessionHelper;
use Slim\Csrf\Guard;
use Gslim\App\Helpers\Logit;
/**
 * Set Bootstrap dependencies
 */
return static function (Application $app, ContainerBuilder $containerBuilder)
{
   $containerBuilder->addDefinitions(
       [
            'csrf'=> function(Application  $app){

                $guard = new Guard($app->getResponseFactory());
                $guard->setPersistentTokenMode(true);           
                return $guard ;
            }, 

            'logit' => function(ContainerInterface $container){
                    $logger = new Logit();
                    return $logger;
            },      
            
            'errorDetail' => function(ContainerInterface $container){
                return $container->get("error");
            },

            'em' => function (ContainerInterface $container) {
                $settings = $container->get('settings');
                $settings = $settings["doctrine"] ;
                $config = Setup::createAnnotationMetadataConfiguration(
                    $settings['meta']['entity_path'],
                    $settings['meta']['auto_generate_proxies'],
                    $settings['meta']['proxy_dir'],
                    $settings['meta']['cache'],
                    false
                );
                return EntityManager::create($settings['connection'], $config);
            },
           'mysql' => function (ContainerInterface $container) {

           },
           'maria' => function (ContainerInterface $container) {

           },
           'ora' => function (ContainerInterface $container) {

            },
            'key' => function (ContainerInterface $container) {

            },
            'apiclient' => function (ContainerInterface $container) {

            },
        ]
   );

};
