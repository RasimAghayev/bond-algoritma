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
    public function test_index_bonds()
    {
        $response = $this->json('GET','api/bonds');

        $response->assertStatus(200);
    }
    /**
     * test create bond.
     *
     * @return void
     */
    public function test_create_bonds()
    {
        $response = $this->json('POST','api/bonds',[
            "emisia_date"=> "2021-11-08",
            "turnover_date"=> "2022-11-03",
            "nominal_price"=> 999,
            "frequency_payment_coupons"=> "12",
            "period_for_calculating_interest"=> "365",
            "coupon_interest"=> 12
        ]);

        //Write the response in laravel.log
        \Log::info(1, [$response->getContent()]);

        $response->assertStatus(200);
    }
}
