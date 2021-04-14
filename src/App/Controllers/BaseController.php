<?php

declare(strict_types=1);

namespace Gslim\App\Controllers;

use Doctrine\ORM\EntityManager as EntityManager;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Gslim\App\Services\BaseServices;
use Gslim\App\Services\ErrorBaseServices;
use Gslim\App\Helpers\Logit;
use Gslim\App\Traits\CoreErrorTrait;
use Gslim\App\Application;

/**
 * Class BaseController
 * @package Gslim\App\Controllers
 * @author gede.suartana <gede.suartana@outlook.com>
 */
abstract class BaseController
{
    /**
     * Set default logger
     *
     * @var Logger
     */
    protected $logit;

    /**
     * Define container interface
     *
     * @var ContainerInterface
     */
    protected $container;
    /**
     * Define Entity manager
     *
     * @var EntityManager
     */
    protected $em;  // Entities Manager
    /**
     * Set public error class
     *
     * @var ErrorBaseServices
     */
    public $error;
    /**
     * Get request body;
     *
     * @var [type]
     */
    public $getRequestBody;

    public $session;

    /**
     * BaseController constructor.
     *
     * @param ContainerInterface $container
     * @param Application $app
     */
    public function __construct(ContainerInterface $container, Application $app)
    {
        $this->container = $container;
        $this->logit = $container->get("logit");
        $this->error = new ErrorBaseServices($container->get("errorDetail"));
        $service = new BaseServices();
        $service->setEntityServiceManager($container->get("em"));
        $service->setLogit( $this->logit );
        $this->getRequestBody = ($GLOBALS["getRequestBody"]) ?? null ;        
    }

    /**
     * Prepare json response
     *
     * @param Response $response
     * @param array $data
     * @return Response
     */
    public  function prepareSuccessResponse(Response $response, array $data = []): Response
    {

        $result = [
            'status' => 1,
            'data' => is_array($data) ? $data : (object) new \stdClass()
        ];

        $response->getBody()->write(json_encode($result));
        return $response
            ->withHeader('Content-Type', 'application/json');
    }
    /**
     * Prepare error response
     *
     * @param Response $response
     * @param $errorCode
     * @return Response
     */
    public  function prepareErrorResponse( Response $response, $errorCode): Response
    {
        $errorDetail = [
            'status' => 0,
            'data' => ['errorCode' => $errorCode, 'errorDesc' => ""]
        ];

        $error = $this->error->getErrorDetail($errorCode);
        if(!empty($error)){
            $errorDetail ['data']['errorDesc'] = $error[1];
        }

        $response->getBody()->write(json_encode($errorDetail));
        return $response
            ->withHeader('Content-Type', 'application/json');
    }


}
