<?php
namespace Gslim\App\Controllers;

use Gslim\App\Controllers\BaseController;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;


class PregReplace extends BaseController
{

    public function index(Request $request, Response $response, array $args = []) : Response
    {
        $params = $request->getParsedBody();

        return $response;
    }

}
