<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TaskTest extends TestCase
{
    /**
     * 1.Bond Interest Maturity Dates
     *
     * @return void
     */
    public function BondInterestMaturityDates()
    {
        $response = $this->json('GET','api/bond/3/payouts');

        //Write the response in laravel.log
        \Log::info(1, [$response->getContent()]);

        $response->assertStatus(200);
    }
    /**
     * 2.Creating a Bond Purchase Order.
     *
     * @return void
     */
    public function CreatingaBondPurchaseOrder()
    {
        $response = $this->json('POST','api/bond/3/order',[
            "order_date"=> "2021-11-23",
            "number_bonds_received"=>  30
        ]);

        //Write the response in laravel.log
        \Log::info(1, [$response->getContent()]);

        $response->assertStatus(200);
    }
    /**
     * 3. Interest Payments on the Bond Order.
     *
     * @return void
     */
    public function InterestPaymentsontheBondOrder()
    {
        $response = $this->json('POST','api/bond/order/3');

        //Write the response in laravel.log
        \Log::info(1, [$response->getContent()]);

        $response->assertStatus(200);
    }
}
