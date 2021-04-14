<?php
declare(strict_types=1);

namespace Gslim\App\Traits;

use Slim\Http\Response;
use Monolog\Utils as Utils;

/**
 * Trait JsonResponseTrait
 * @package Gslim\App\Traits
 * @author gede.suartana <gede.suartana@outlook.com>
 */
trait JsonResponseTrait
{
    /**
     * Sends a JSON to the consumer
     *
     * @param $status
     * @param $response
     * @param null $data
     * @return mixed
     */
    public function jsonResponse( $data = null, Response $response) : Response
    {
        $response->getBody()->write(
            Utils::jsonEncode(
                ["data" => $data ]
            )
        );
        return $response->withHeader('Content-Type', 'application/json');
    }

    /**
     * Set result
     *
     * @param boolean $status [default false]
     * @param $code
     * @param $data
     * @return array
     */
    public function setResult( bool $status = false, $code, $data ): array
    {
        return [
            "status" => $status,
            "error_code" => $code,
            "data" => $data
        ];
    }


}