<?php
declare(strict_types=1);

use DI\ContainerBuilder;
use Monolog\Logger;

/**
 * Settings
 */
return static function (ContainerBuilder $containerBuilder)
{
    $containerBuilder->addDefinitions([
        'error' => [
            "ERROR_PAGE_NOT_FOUND" => "Error page you requested not found in our application",
            "EMAIL_NOT_FOUND" => "Your email not found"

        ],
    ]);
};
