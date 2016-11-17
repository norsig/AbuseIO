<?php

namespace tests;

use Illuminate\Foundation\Testing\WithoutMiddleware;

class ApiDomainCheckerControllersTest extends TestCase
{
    /*
     * This is required else it would generate:
     *  Fatal error:  Maximum function nesting level of '100' reached, aborting
     */
    use WithoutMiddleware;

    /**
     * @return void
     */
    public function testAdminRedirect()
    {
        $response = $this->call('POST', '/admin/verifyexternalapi', ['url' => 'http://localhost:80']);

        $this->assertEquals(200, $response->getStatusCode());
    }
}