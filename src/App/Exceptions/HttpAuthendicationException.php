<?php

namespace Gslim\App\Exceptions;

use Slim\Exception\HttpSpecializedException;

class HttpAuthendicationException extends HttpSpecializedException 
{
    protected $code = 401;
    protected $message = 'ERR_UNAUTHOZIED_ACCESS';
    protected $title = 'ERR_UNAUTHOZIED_ACCESS';
    protected $description = 'ERR_UNAUTHOZIED_ACCESS';

    function constract($description) {
        parent::__construct();
        $this->description = $description;
    }
}