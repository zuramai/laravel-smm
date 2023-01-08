<?php

namespace Database\Seeders;

use App\Service;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Service::insert([
            [
                'name' => 'Test Layanan',
                'category_id' => 1,
                'note' => 'asdasd',
                'min' => 1,
                'max' => 111,
                'price' => 11,
                'price_oper' => 111,
                'keuntungan' => 111,
                'type' => 'Basic',
                'status' => 'Active',
                'pid' => 111,
                'provider_id' => 1
            ]
        ]);
    }
}
