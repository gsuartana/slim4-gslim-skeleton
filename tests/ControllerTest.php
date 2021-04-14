<?php

use Slim\Environment as Environment;

use PHPUnit\Framework\TestCase;
use Slim\Http\Request;
use Slim\Http\Response;

class ControllerTest extends TestCase
{

    public function testIndexController()
    {
        // Create a stub for the index controller class.
        $stub = $this->getMockBuilder(\Gslim\App\Controllers\IndexController::class)
            ->disableOriginalConstructor()
            ->disableOriginalClone()
            ->disableArgumentCloning()
            ->disallowMockingUnknownTypes()
            ->getMock();

        // Configure the stub.
        $stub->method('testMe')
            ->willReturn('testMe');

        $this->assertSame('testMe', $stub->testMe() );

    }


}