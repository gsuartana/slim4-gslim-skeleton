<?php
declare(strict_types=1);

use DI\ContainerBuilder;
use Monolog\Logger;

/**
 * Settings
 */
return static function (ContainerBuilder $containerBuilder)
{
    $rootPath = realpath(__DIR__ . '/..');
    $containerBuilder->addDefinitions([
        'settings' => [
            "env" => getenv("APP_ENV"),
            // Base path
            'base_path' => '',
            'app_url' => getenv('APP_URL'),
            'debug' => getenv('APP_DEBUG'),
            // Project unique identifier
            'app_id' => getenv('APP_ID'),
            // 'Temprorary directory
            'temporary_path' => $rootPath . '/storage/tmp',
            // Route cache
            'route_cache' => $rootPath . '/storage/cache',

            'doctrine' => [
                // if true, metadata caching is forcefully disabled
                'dev_mode' => true,
                // path where the compiled metadata info will be cached
                // make sure the path exists and it is writable
                'cache_dir' =>  'storage/storage',
                // you should add any other path containing annotated entity classes
                'metadata_dirs' => ['App/Entity'],
                'meta' => [
                    'entity_path' => [ 'App/Entity' ],
                    'auto_generate_proxies' => true,
                    'proxy_dir' => 'storage/cache/proxies',
                    'cache' => null,
                ],
                'connection' => [
                    'driver' =>  'pdo_mysql',
                    'host' => getenv('DB_HOST'),
                    'port' => getenv('DB_PORT'),
                    'dbname' => getenv('DB_DATABASE'),
                    'user' => getenv('DB_USERNAME'),
                    'password' => getenv('DB_PASSWORD'),
                    'charset' => getenv('DB_CHARSET'),
                ]
            ],
            // monolog settings
            'logger' => [
                'name' => 'app',
                'path' =>  getenv('LOG_PATH'),
                'level' => getenv('LOG_LEVEL'),
            ],
            'session' => [
                // Session cookie settings
                'name'           => 'gslim_session',
                'lifetime'       => 24,
                'path'           => '/',
                'domain'         => null,
                'secure'         => false,
                'httponly'       => true,
        
                // Set session cookie path, domain and secure automatically
                'cookie_autoset' => true,
        
                // Path where session files are stored, PHP's default path will be used if set null
                'save_path'      => null,
        
                // Session cache limiter
                'cache_limiter'  => 'nocache',
        
                // Extend session lifetime after each user activity
                'autorefresh'    => false,
        
                // Encrypt session data if string is set
                'encryption_key' => null,
        
                // Session namespace
                'namespace'      => 'gslim_app'
            ]
        ],
    ]);
};
