<?php

namespace Database\Seeders;

use App\Provider;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProviderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Provider::insert([
            'name' => 'test',
            'type' => 'SOSMED',
            'order_type' => 'API',
            'api_id' => 1
        ]);
    }
}
