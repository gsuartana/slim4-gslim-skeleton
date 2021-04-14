<?php
// cli-config.php
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Console\ConsoleRunner;

define("ROOT_PATH", dirname(__DIR__) . DIRECTORY_SEPARATOR);
/**
 * Load configuration information
 */
$config = [
    // if true, metadata caching is forcefully disabled
    'dev_mode' => true,
    // path where the compiled metadata info will be cached
    // make sure the path exists and it is writable
    'cache_dir' =>  'storage/storage',
    // you should add any other path containing annotated entity classes
    'metadata_dirs' => ['api/Entity'],
    'meta' => [
        'entity_path' => [ 'api/Entity' ],
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
];
$setup = Setup::createAnnotationMetadataConfiguration($config["metadata_dirs"], $config['dev_mode']);
$entityManager = EntityManager::create($config["connection"], $setup);
return ConsoleRunner::createHelperSet($entityManager);