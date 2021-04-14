<?php
namespace Gslim\App\Controllers;

use Gslim\App\Services\SubmitErrorRecorderService;
use Gslim\App\Services\YasMasterTokenService;
use Gslim\App\Traits\ApplicationErrorTrait;
use Gslim\App\Traits\JsonResponseTrait;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Gslim\App\Controllers\BaseController;

/**
 * Class HealthCheckController
 * @package Gslim\App\Controllers
 * @author gede.suartana <gede.suartana@outlook.com>
 */
class HealthCheckController extends BaseController
{

    /**
     * Polls backends and if they respond with HTTP 200 + an optional request body,
     * they are marked good. Otherwise, they are marked bad.
     *
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return Response
     */
    public function index(Request $request, Response $response, array $args = []) : Response
    {
        $this->logit->info(
            "Health check started",
            __CLASS__.".".__FUNCTION__
        );
        
        return $this->prepareSuccessResponse( $response );
    }

}
