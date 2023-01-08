<?php

namespace Database\Seeders;

use App\ApiRequestHeader;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ApiRequestHeaderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ApiRequestHeader::insert([
            [
                'header_key' => 'asd', 
                'header_value' => 'asd', 
                'header_type' => 'custom', 
                'api_type' => 'order', 
                'api_id' => 1, 
            ],
            [
                'header_key' => 'asd', 
                'header_value' => 'asd', 
                'header_type' => 'custom', 
                'api_type' => 'status', 
                'api_id' => 1, 
            ]
            ]);
    }
}
