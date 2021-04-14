<?php
namespace Gslim\App\Controllers;

use Gslim\App\Services\SubmitErrorRecorderService;
use Gslim\App\Services\MasterTokenService;
use Gslim\App\Traits\JsonResponseTrait;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Gslim\App\Controllers\BaseController;


class IndexController extends BaseController
{
    use JsonResponseTrait;

    public function index(Request $request, Response $response, array $args = []) : Response
    {     
        $masterTokenService = new MasterTokenService();
        $data = $masterTokenService->getAll();
        return $this->prepareSuccessResponse($response, $data);
    }

    public function testMe()
    {
        echo "testme";
    }
    /**
     * Get Csrf token
     *
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @param \Psr\Http\Message\ResponseInterface $response
     * @param array $args
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function getToken(Request $request, Response $response, array $args = []) : Response
    {
        $csrf = $this->container->get('csrf');
        $nameKey = $csrf->getTokenNameKey();
        $valueKey = $csrf->getTokenValueKey();
        $name = $request->getAttribute($nameKey);
        $value = $request->getAttribute($valueKey);
    
        $tokenArray = [
            $nameKey => $name,
            $valueKey => $value
        ];
                
        return $this->prepareSuccessResponse($response, $tokenArray);
    }

    
}
