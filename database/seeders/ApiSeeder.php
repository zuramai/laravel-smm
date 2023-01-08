<?php

namespace Database\Seeders;

use App\API;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ApiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        API::create([
        'name' => 'test', 
        'order_end_point' => 'https://asd.com', 
        'order_success_response' => '{\r\n\"success\":true\r\n}', 
        'order_method' => 'POST', 
        'status_end_point' => 'https://asd.com', 
        'status_success_response' => '{\r\n\"success\":true\r\n}', 
        'status_method' => 'POST', 
        'order_id_key' => 'order', 
        'start_counter_key' => 'start_count', 
        'status_key' => 'status', 
        'remains_key' => 'remains', 
        'process_all_order' => 1, 
        'created_at' => '2022-01-09 03:45:33', 
        'updated_at' => '2022-01-09 03:45:33', 
        'api_key' => '', 
        'link' => 'https://asd.com', 
        'type' => 'SOSMED'
        ]);
    }
}
