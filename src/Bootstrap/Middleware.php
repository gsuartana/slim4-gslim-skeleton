<?php

use Gslim\App\Application;
use Slim\Factory\ServerRequestCreatorFactory as ServerRequestCreatorFactory;
use Gslim\App\Handlers\HttpErrorHandler;
use Gslim\App\Handlers\ShutdownHandler;
use Gslim\App\Middleware\RequestLogMiddleware;
use Gslim\App\Middleware\SchemaValidationMiddleware;

/**
 * Set Middleware application
 */
return static function (Application $app)
{
    //Show error details yes or not
    $displayErrorDetails = $app->getEnvironment() === 'local' ? true : false;
    // add routing middleware
    $app->addRoutingMiddleware();
    // add new json schema validation
    $app->add(new RequestLogMiddleware());
    $app->add(new SchemaValidationMiddleware());
    //set variables
    $callableResolver = $app->getCallableResolver();
    $responseFactory = $app->getResponseFactory();
    $serverRequestCreator = ServerRequestCreatorFactory::create();
    $request = $serverRequestCreator->createServerRequestFromGlobals();
    //set new objects
    $errorHandler = new HttpErrorHandler($callableResolver, $responseFactory);
    $shutdownHandler = new ShutdownHandler($request, $errorHandler, $displayErrorDetails);
    //Register a function for execution on shutdown
    register_shutdown_function($shutdownHandler);
    // Add Error Handling Middleware
    $errorMiddleware = $app->addErrorMiddleware($displayErrorDetails, false, false);
    $errorMiddleware->setDefaultErrorHandler($errorHandler);
    
};
