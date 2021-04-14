<?php

namespace Gslim\App\Services;

/**
 * Class ErrorBaseServices
 * @package Gslim\App\Services
 */
class ErrorBaseServices
{
    /**
     * Set error array
     *
     * @var $errorDetail
     */
    protected $errorDetail;

    public function __construct($appError)
    {
        $this->initErrorCode($appError);
    }

    /**
     * Get error details
     *
     * @param $errorCode
     * @return mixed|null
     */
    public function getErrorDetail($errorCode)
    {
        if (isset($this->errorDetail[$errorCode]))
            return $this->errorDetail[$errorCode];

        return null;
    }

    /**
     * Merge the core and application layer array
     *
     * @param array $appError
     * @return array
     */
    public function initErrorCode(array $appError = []): array
    {
       return $this->errorDetail =  array_merge(
            $this->setSystemError(),
            $appError
        );
    }

    /**
     * Set system error in array
     *
     * @return string[]
     */
    private function setSystemError(): array
    {
        $ret = [
            "ERR_SYSTEM_ERROR" => "System Error"
        ];
        return $ret;
    }



}