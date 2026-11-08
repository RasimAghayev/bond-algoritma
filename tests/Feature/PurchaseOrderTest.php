<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PurchaseOrderTest extends TestCase
{
    use RefreshDatabase;

    public function test_example()
    {
        $response = $this->json('GET', 'api/purchase_orders');

        $response->assertStatus(200);
    }
}
