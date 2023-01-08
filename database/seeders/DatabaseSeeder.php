<?php

namespace Database\Seeders;

use App\ApiRequestParam;
use Database\Seeders\UserSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UserSeeder::class,
            ConfigSeeder::class,
            ApiSeeder::class,
            ApiRequestParamSeeder::class,
            ApiRequestHeaderSeeder::class,
            ProviderSeeder::class,
            ServiceCategorySeeder::class,
            ServiceSeeder::class,
        ]);
    }
}
