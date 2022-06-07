<?php

namespace Database\Seeders;

use App\Models\PurchaseOrder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PurchaseOrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        PurchaseOrder::factory()
            ->times(3)
            ->create();
    }
}
