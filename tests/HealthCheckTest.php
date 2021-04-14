<?php

use PHPUnit\Framework\TestCase;
use GuzzleHttp\Client;

class HealthCheckTest extends TestCase
{

    private $url = "http://gslim.lo/";


    /**
     * Test if the healtcheck work
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testRouteExists()
    {
        $client = new Client();
        $request = $client->get("{$this->url}healthcheck" );
        $response = $request;
        $this->assertEquals($response->getStatusCode(), 200);
    }

    /**
     * Test if the route not exists
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testRouteNotExists()
    {
        $client = new Client(['http_errors' => false]);
        $response  = $client->get("{$this->url}healthchecks");
        $this->assertEquals(404, $response->getStatusCode());
    }


}
