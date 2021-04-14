<?php

namespace Gslim\App\Middleware;

use Monolog\Utils;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\MiddlewareInterface as Middleware;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Gslim\App\Helpers\Logit;

class RequestLogMiddleware implements Middleware
{
    /**
     * @var
     */
    protected $request;
    /**
     * @var
     */
    protected $response;
    /**
     *
     * @var Logit
     */
    protected $logit;

    /**
     * RequestLogMiddleware constructor.
     */
    public function __construct()
    {
        $this->logit = new Logit();
    }

    /**
     * Process the request middleware
     *
     * @param Request $request
     * @param RequestHandler $handler
     * @return Response
     */
    public function process(Request $request, RequestHandler $handler): Response
    {
        global $loggerCid,
               $loggerUID;

        $this->logit->debug(
            "RequestLog process started",
            __CLASS__.".".__FUNCTION__
        );

        if ($request->getMethod() == "OPTIONS") {
            return $handler->handle($request);
        }

        //@todo get CID and SID, if exists value set in global
        $params = $request->getQueryParams();
        $loggerCid = ($params['cid']) ?? null;
        $loggerUID = ($params['sid']) ?? null;


        $this->request = $request;
        $this->response = $handler->handle($request);

        $responseData = (array)json_decode(
            (
            preg_replace('/  */', ' ', $this->response->getBody())
            )
        );

        $logLevel = isset($responseData['status']) && ($responseData['status']) ? 'info' : 'warning';
        $this->logit->{$logLevel}(
            "response",
            __CLASS__.".".__FUNCTION__,
            $responseData
        );

        return $this->response;
    }


}
