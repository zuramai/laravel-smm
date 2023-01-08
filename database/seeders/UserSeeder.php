<?php

namespace Database\Seeders;

use App\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Ramsey\Uuid\Uuid;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => 'admin',
            'balance' => '99999',
            'level' => 'developer',
            'status' => 'active',
            'api_key' => Uuid::uuid4(),
            'uplink' => null,
            'phone' => '',
            'username' => 'admin'
        ]);
    }
}
