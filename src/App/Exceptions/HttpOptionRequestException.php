<?php

namespace Gslim\App\Exceptions;

use Slim\Exception\HttpSpecializedException;

class HttpOptionRequestException extends HttpSpecializedException 
{
    protected $code = 200;
    protected $message = '';
    protected $title = '';
    protected $description = '';

    function constract($description) {
        parent::__construct();
        $this->description = $description;
    }
}