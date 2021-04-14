<?php

namespace Gslim\App\Helpers;

use DateTimeZone;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Formatter\LineFormatter;
use Psr\Log\LogLevel;

class Logit
{

    /**
     * Set log replace items with value password
     *
     * @var array
     */
    private $logReplaceItems = ['password'];

    /**
     * Set log name
     *
     * @var string
     */
    private $loggerName = 'GslimLog';

     /**
     * Set timezone log
     *
     * @var string
     */
    private $loggerTimeZone = 'Europe/Zurich';

    /**
     * Set log format
     *
     * @var string
     */
    private $loggerFormat = "%datetime% %level_name% %message% %context%\n";

    /**
     * Set log date time format
     *
     * @var string
     */
    private $loggerTimeFormat = "Y-m-d H:i:s,u";

    /**
     * Set log minimum level
     *
     * @var string
     */
    private $loggerMinimumLevel = LogLevel::DEBUG;

    /**
     * Set debugging mode
     *
     * @var bool
     */
    static $debugging = false;

    protected $logger;
    protected $streamHandler;

    /**
     * Logit constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        $logger = new Logger($this->loggerName); 
        //call stream handler
        $streamHandler = new StreamHandler(
            $this->getLogPath(),
            $this->loggerMinimumLevel
        );
        //Control the use of microsecond resolution timestamps in the 'datetime'
        $logger->useMicrosecondTimestamps(true);
        //Sets the timezone to be used for the timestamp of log records
        $logger->setTimezone($this->getLoggerTimeZone());
        //set stream handler
        $streamHandler = $streamHandler->setFormatter($this->getLineFormatter());
        //Pushes a handler on to the stack
        $logger->pushHandler($streamHandler);
        //Adds a processor on to the stack
        $logger->pushProcessor($this->addLoggerFilteringFor($this->logReplaceItems));
        $this->logger = $logger;
    }

    /**
     * Is in debugging mode
     *
     * @return bool
     */
    public function isDebugging():bool
    {
        return self::$debugging;
    }

    /**
     * Provide Datetime Zone 'Europe/Zurich'
     *
     * @return DateTimeZone
     */
    private function getLoggerTimeZone()
    {
        return new DateTimeZone($this->loggerTimeZone);
    }

    /**
     * Provide log path
     *
     * @return string
     */
    protected function getLogPath()
    {
        return getenv("APP_ENV") == 'local' ?
            ROOT_PATH.getenv("LOG_PATH") :
            getenv("LOG_PATH");
    }

    /**
     * Provide line formatter
     */
    private function getLineFormatter()
    {
        return new LineFormatter(
            $this->loggerFormat,
            $this->loggerTimeFormat,
            true,
            true
        );
    }

    /**
     * Add log Filter
     *
     * @param array $filters
     * @return \Closure
     */
    private function addLoggerFilteringFor(array $filters)
    {
        return function ($record) use ($filters) {
            foreach ($filters as $key) {
                if (isset($record['context'][$key])) {
                    $record['context'][$key] = "******";
                }
            }
            return $record;
        };
    }

    /**
     * Store logging level into the log.fine
     * Development log store it on the local path [storage/logs]
     * Production log store it on the server tmp path [STDOUT]
     *
     *
     * @param $level
     * @param $context
     * @param $message
     * @param array $data
     * @throws Exception
     */
    
    private function setLogger(string $level, string $message, $context, array $data = []):void
    {
        global $loggerCid,
               $loggerUID,
               $reqId;

        if ($loggerUID == null) {
            $bytes = random_bytes(10);
            $loggerUID = bin2hex($bytes);
        }

        //set logger client id
        $loggerCid = ($loggerCid != "") ? $loggerCid : $loggerUID;
        $cid = $loggerCid;
        if ($reqId != "") {
            $cid = $loggerCid . "_" . $reqId;
        }
        $localmessage = sprintf("[%s] SID=%s CID=%s [main] %s ", $context, $loggerUID, $cid, $message);
        $this->logger->{$level}($localmessage, $data);
    }


    /**
     * Set the emergency log
     *
     * @param string $message
     * @param $context
     * @param array $data
     * @throws Exception
     */
    public function emergency(string $message, $context, array $data = []): void
    {
        $this->setLogger(
            LogLevel::EMERGENCY,
            $message,
            $context,
            $data
        );
    }

    /**
     * Set alert log
     *
     * @param string $message
     * @param $context
     * @param array $data
     * @throws Exception
     */
    public function alert(string $message, $context, array $data = []): void
    {
        $this->setLogger(
            LogLevel::ALERT,
            $message,
            $context,
            $data
        );
    }

    /**
     * Set critical log
     *
     * @param string $message
     * @param $context
     * @param array $data
     * @throws Exception
     */
    public function critical(string $message, $context, array $data = []): void
    {
        $this->setLogger(
            LogLevel::CRITICAL,
            $message,
            $context,
            $data
        );
    }

    /**
     * Set error log
     *
     * @param string $message
     * @param $context
     * @param array $data
     * @throws Exception
     */
    public function error(string $message, $context, array $data = []): void
    {
        $this->setLogger(
            LogLevel::ERROR,
            $message,
            $context,
            $data
        );
    }

    /**
     * Set warning log
     *
     * @param string $message
     * @param $context
     * @param array $data
     * @throws Exception
     */
    public function warning(string $message, $context, array $data = []): void
    {
        $this->setLogger(
            LogLevel::WARNING,
            $message,
            $context,
            $data
        );
    }

    /**
     * Set notice log
     *
     * @param string $message
     * @param $context
     * @param array $data
     * @throws Exception
     */
    public function notice(string $message, $context, array $data =[]): void
    {
        $this->setLogger(
            LogLevel::NOTICE,
            $message,
            $context,
            $data
        );
    }

    /**
     * Set info log
     *
     * @param string $message
     * @param $context
     * @param array $data
     * @throws Exception
     */
    public function info(string $message, $context, array $data = [] ): void
    {
        $this->setLogger(
            LogLevel::INFO,
            $message,
            $context,
            $data
        );

    }

    /**
     * Set debug log
     *
     * @param string $message
     * @param $context
     * @param array $data
     * @throws Exception
     */
    public function debug(string $message, $context, array $data = [] ): void
    {
        $this->setLogger(
            $this->loggerMinimumLevel,
            $message,
            $context,
            $data
        );

    }

    /**
     * Set default log with loggerMinimumLevel = warning
     *
     * @param string $message
     * @param $context
     * @param array $data
     * @throws Exception
     */
    public function logit(string $message, $context, array $data = []): void
    {
        $this->setLogger(
            $this->loggerMinimumLevel,
            $message,
            $context,
            $data
        );
    }

}