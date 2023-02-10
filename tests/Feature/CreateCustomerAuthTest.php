<?php

namespace Tests\Feature;

use Tests\ApplicationTestCase;

class CreateCustomerAuthTest extends ApplicationTestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testCreateCustomerAuth()
    {
        $response = $this->withCustomerAuth()
            ->getJson('api/v1/my/profile', []);

        $response->assertJson([
            'code' => 2000,
        ]);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testCreateSalerAuth()
    {
        $response = $this->withSalerAuth()
            ->getJson('sale-api/v1/stores', []);

        $response->assertJson([
            'code' => 2000,
        ]);
    }
}
