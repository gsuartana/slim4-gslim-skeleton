<?php

namespace Gslim\App\Exceptions;

use Slim\Exception\HttpSpecializedException;

class HttpInvalidJsonSchemaException extends HttpSpecializedException 
{
    protected $code = 400;
    protected $message = 'ERR_JSON_VALIDATION_FAILED';
    protected $title = 'ERR_JSON_VALIDATION_FAILED';
    protected $description = 'ERR_JSON_VALIDATION_FAILED';

    function constract($description) {
        parent::__construct();
        $this->description = $description;
    }
}