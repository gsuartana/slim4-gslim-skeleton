<?php

namespace Gslim\App\Traits;


trait CoreErrorTrait{

    public $errorDetail;

    public function getErrorDetail($errorCode)
    {
        if (isset($this->errorDetail[$errorCode]))
            return $this->errorDetail[$errorCode];

        return null;
    }

    public function initErrorCode()
    {
        $ret = [
            "ERR_SYSTEM_ERROR" => "System Error"
        ];
        $this->errorDetail = $ret;
    }
}