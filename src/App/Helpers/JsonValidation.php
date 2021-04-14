<?php

namespace Gslim\App\Helpers;

use JsonSchema\Validator;
use Monolog\Utils;
use PHPUnit\Util\Json;

class JsonValidation
{
   /**
     * @var null
     */
    protected $requestJson = [];

    /**
     * Validate json schema Validate json schema
     *
     * @param $requestJson
     * @param $restApi
     * @return array|int[]
     */
    public function validateJson($requestJson, $restApi): array
    {

        $restApiSchema = $this->loadJsonSchema($restApi);
        
        if(!$restApiSchema){
            return [
                'status' => 0,
                'error_code' => 'ERR_SCHEMA_NOT_FOUND_FOR_THE_REQUEST',
                'details' => 'Invalid route'
            ];
        }

        $this->requestJson = $this->decodeJson($requestJson);
   
        $validator = new Validator;
        $validator->validate(
            $this->requestJson['json'],
            (object) array('$ref' => 'file://' . realpath($this->jsonFilePath($restApi)))
        );

        if ($validator->isValid()) {
            return [
                'status' => 1, 
                "data" =>  $this->requestJson['json']
            ];
        }

        $errors = null;
        foreach ($validator->getErrors() as $error) {
            $errors[] = sprintf("%s %s", $error['property'], $error['message']);
        }

        return ['status' => 0, 'error_code' => 'ERR_JSON_SCHEMA_VIOLATION', 'details' => $errors];
    }

    /**
     * Decoding json data
     *
     * @param $json
     * @return array
     */
    public function decodeJson($json): array
    {
        $json = json_decode($json);

        if ($json == NULL)
            return ['status' => 0, 'error_code' => 'ERR_INVALID_JSON'];

        return ['status' => 1, 'json' => $json];
    }

    /**
     * Define json file path
     *
     * @param $jsonFilename
     * @return string
     */
    protected function jsonFilePath($jsonFilename): string
    {  
        $dir = ROOT_PATH."src/App/Routes/Schemas/";
        return "{$dir}{$jsonFilename}.json";
    }

    /**
     * Provide jsonschema file
     *
     * @param string $jsonFilename
     * @return false|string
     */
    public function loadJsonSchema(string $jsonFilename)
    {
        $jsonFilename = $this->jsonFilePath($jsonFilename);
        if(file_exists( $jsonFilename)){
           return Utils::jsonEncode(file_get_contents($jsonFilename));
        }
        return false;
    }

}