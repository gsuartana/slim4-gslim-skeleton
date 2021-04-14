<?php

namespace Gslim\App\Services;


use Exception;
use Gslim\App\Traits\JsonResponseTrait;
use http\Env\Response;
use Support\Exception\ErrorNotice;
use Gslim\App\Services\BaseServices;
use Gslim\App\Entity\BaseEntity;
use Gslim\App\Entity\ErrorRecorder as EntityErrorRecorder;

class AddErrorService extends BaseServices
{
    use JsonResponseTrait;

       /**
        * Create error report
        *
        * @param $request
        * @param $em
        * @return Response
        * @throws ErrorNotice
        */
       public function create($request)
       {
           $id = $this->addErrorsToDB($request);   
           if(!$id) {
               return ['status' => 0, 'errorCode' => 'ERR_WHILE_ADDING_TO_DB'];
           }
           return ['status' => 1];
       }
       /**
        * Add error into the table
        *
        * @param $request
        * @param $em
        * @return int
        */
       public function addErrorsToDB($request): int
       {    
           $lastInsertedId = 0;
           try{
                $recorder = new EntityErrorRecorder();
                $recorder->setType($request->type);
                $recorder->setMessage($request->message);
                $recorder->setSource($request->source);
                $recorder->setUserAgent($request->userAgent);
                $recorder->setLocation($request->location);
                // tell Doctrine you want to (eventually) save the table (no queries yet)
                self::entityManagers()->persist($recorder);
                // actually executes the queries (i.e. the INSERT query)
                self::entityManagers()->flush();
                $lastInsertedId = $recorder->getId();
                // get last inserted id
           }catch(Exception $ex){
                $this->logits()->error(
                    "Error",
                    __CLASS__.".".__FUNCTION__,
                ["msg" => $ex->getMessage()]
                ) ;
           }
           return $lastInsertedId;
       }
    
   
}