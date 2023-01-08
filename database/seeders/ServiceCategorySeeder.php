<?php

namespace Database\Seeders;

use App\Service_cat;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServiceCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Service_cat::insert([
            [
                'name' => 'Instagram Followers',
                'type' => 'SOSMED',
                'status' => 'ACTIVE',
            ],
            [
                'name' => 'Pulsa',
                'type' => 'PULSA',
                'status' => 'ACTIVE',
            ]
            ]);
    }
}
