<?php

namespace Gslim\App\Middleware;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\MiddlewareInterface as Middleware;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Gslim\App\Helpers\JsonValidation;
use Gslim\App\Exceptions\HttpInvalidJsonSchemaException;
use Monolog\Utils;
use Gslim\App\Helpers\Logit;

class SchemaValidationMiddleware implements Middleware
{

    /**
     * Set object
     *
     * @var [object]
     */
    protected $logit;

    /**
     * SchemaValidationMiddleware constructor.
     */
    public function __construct()
    {
        $this->logit = new Logit();
    }
      /**
     * The processing of the schema validation middleware
     *
     * @param Request $request
     * @param RequestHandler $handler
     * @return Response
     */
    public function process(Request $request, RequestHandler $handler): Response
    {
        $this->logit->debug(
            "SchemaValidation process started",
            __CLASS__.".".__FUNCTION__
        );

        if($request->getMethod() == 'POST'){
            $this->validate($request);
        }

        return $handler->handle($request);
    }

    /**
     * Validate schema
     *
     * @param [type] $request
     * @return void
     */
    protected function validate(Request $request)
    {
        $this->logit->debug(
            "SchemaValidation validate started",
            __CLASS__.".".__FUNCTION__
        );
        $requestUrl = $request->getUri()->getPath();
        $restApiAction = substr(str_replace('-','_',str_replace('/','_', $requestUrl)), 1);
        $requestBody = (string) $request->getBody();

        $jsonData = Utils::jsonEncode($requestBody);
        if($jsonData == null){
            $errorDesc = "INVALID_JSON_FORMAT";
            $this->logit->warning(
                "Json data returned null,{$errorDesc}",
                __CLASS__.".".__FUNCTION__
            );
            throw new HttpInvalidJsonSchemaException($request, $errorDesc);
        }

        $jsonSchemaValidation = new JsonValidation();
        $result = $jsonSchemaValidation->validateJson($requestBody, $restApiAction);

        if ($result['status'] == 0) {
            $this->logit->warning(
                "Json schema validation result failed, error",
                __CLASS__.".".__FUNCTION__,
                $result
            );
            $details = ($result['details']) ?? null;
            $errorDesc = getenv("APP_ENV") != 'production' ?  json_encode($details) : $result['error_code'];

            throw new HttpInvalidJsonSchemaException($request, $errorDesc);
        }
        global $getRequestBody;
        $getRequestBody = $result["data"];
    }

}

