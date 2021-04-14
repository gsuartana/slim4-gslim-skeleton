<?php

namespace Gslim\App\Exceptions;

use Slim\Exception\HttpSpecializedException;

class UserAccessException extends HttpSpecializedException
{
    protected $code = 500;
    protected $message = 'ERR_SYSTEM_ERROR';
    protected $title = 'ERR_SYSTEM_ERROR';
    protected $description = 'ERR_SYSTEM_ERROR';

    function constract($description) {
        parent::__construct();
        $this->description = $description;
    }
}