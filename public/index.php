<?php
/**
 * Set Timezone
 * @author gede.suartana <gede.suartana@outlook.com>
 */
date_default_timezone_set('Europe/Zurich');
/**
 * Set root path
 */
define("ROOT_PATH", dirname(__DIR__) . DIRECTORY_SEPARATOR);
require ROOT_PATH . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';
/**
 * Require the classes
 */
use Gslim\App\Application;
/**
 * Start the application
 */
$app = new Application();
/**
 * Run the slim application
 */
$app->run();
