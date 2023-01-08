<?php

namespace Database\Seeders;

use App\ApiRequestParam;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ApiRequestParamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ApiRequestParam::insert([
            [
                'param_key' => 'asd',
                'param_value' => 'target' ,
                'param_type' => 'table_column',
                'api_type' => 'order',
                'api_id' => 1,
            ],
            [
                'param_key' => 'asd',
                'param_value' => 'id' ,
                'param_type' => 'table_column',
                'api_type' => 'status',
                'api_id' => 1,
            ],
        ]);
    }
}
