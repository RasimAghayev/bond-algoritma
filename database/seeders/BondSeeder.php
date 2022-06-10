<?php

namespace Database\Seeders;

use App\Models\Bond;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BondSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Bond::factory()
            ->times(3)
            ->create();
    }
}
