<?php
namespace Gslim\App\Controllers;


use Gslim\App\Controllers\BaseController;
use Gslim\App\Services\AddErrorService;
use Gslim\App\Services\ErrorBaseServices;
use Gslim\App\Services\SubmitAppErrorService;
use Gslim\App\Traits\JsonResponseTrait;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

/**
 * Class SubmitErrorRecorderController
 * @package Gslim\App\Controllers
 * @author gede.suartana <gede.suartana@outlook.com>
 */
class ErrorController extends BaseController
{
    use JsonResponseTrait;
    /**
     * Sending error information to Telegram and saving the data record in the database
     *
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @param \Psr\Http\Message\ResponseInterface $response
     * @param array $args
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function index(Request $request, Response $response, array $args = []) : Response
    {  
        $guard = $this->container->get("csrf");      
        $params = $this->getRequestBody;     
        // Validate retrieved tokens
        $validated  = $guard->validateToken(
            $params->csrf_name,  
            $params->csrf_value 
        );
        // set new objects
        $submit = new AddErrorService();         
        //create error and send message via telegram
        $errRec = $submit->create($this->getRequestBody);

        if(!$errRec['status']) {

            $this->logit->info(
                "prepareErrorResponse", 
                __CLASS__.".".__FUNCTION__, 
                $errRec['errorCode']
            );

            return $this->prepareErrorResponse($response, $errRec['errorCode']);
        }
        
        return $this->prepareSuccessResponse($response, ["msg" => "inserted"]);
    }

}
