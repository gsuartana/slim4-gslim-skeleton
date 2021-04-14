<?php
declare(strict_types=1);

use Gslim\App\Application;
use Slim\Routing\RouteCollectorProxy;
/**
 * Sliw route configuration
 */
return static function (Application $app)
{

    //healtcheck response 200
    $app->get(
        '/healthcheck', 
        \Gslim\App\Controllers\HealthCheckController::class. ':index'
    );
    
    $app->group('/api', function (RouteCollectorProxy $group) 
    { 
        $group->get(
            '/haskey', 
            \Gslim\App\Controllers\IndexController::class. ':index'
        );
         
        $group->get(
            '/token', 
            \Gslim\App\Controllers\IndexController::class. ':getToken'
        )->add("csrf");

        //sending message to telegram
        $group->post(
            '/adderror',
            \Gslim\App\Controllers\ErrorController::class. ':index'
        )->add("csrf");
        
    });
    
  
};

