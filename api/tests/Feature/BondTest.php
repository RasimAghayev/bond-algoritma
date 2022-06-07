<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BondTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
    /**
     * test create product.
     *
     * @return void
     */
    public function test_create_product()
    {
        $response = $this->json('POST','api/bonds',[
            'name' => 'Test product',
            'sku' => 'test-sku',
            'upc' => 'test-upc'
        ]);

        //Write the response in laravel.log
        \Log::info(1, [$response->getContent()]);

        $response->assertStatus(200);
    }
}
