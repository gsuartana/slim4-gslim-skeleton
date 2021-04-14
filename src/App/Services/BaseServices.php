<?php

namespace Gslim\App\Services;

use Doctrine\ORM\EntityManager;

/**
 * Class BaseServices
 * @package Gslim\App\Services
 */
class BaseServices
{   

    static $entityManager;

    static $logit;


    public function setEntityServiceManager($em){
        self::$entityManager = $em;
    }

    public static function entityManagers()
    {
        return self::$entityManager;
    }

    public function setLogit($em){
        self::$logit = $em;
    }

    public static function logits()
    {
        return self::$logit;
    }



}