<?php

namespace Gslim\App\Exceptions;

use Slim\Exception\HttpSpecializedException;

class HttpInvalidCorsException extends HttpSpecializedException 
{
    protected $code = 400;
    protected $message = 'CROSS_SITE_REQUEST_FORBIDDEN';
    protected $title = 'CROSS_SITE_REQUEST_FORBIDDEN';
    protected $description = 'CROSS_SITE_REQUEST_FORBIDDEN';

    function constract($description) {
        parent::__construct();
        $this->description = $description;
    }
}