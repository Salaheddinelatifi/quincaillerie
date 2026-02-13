<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class AdminSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Admin',
            'email' => 'salah@abquincaillerie.com',
            'password' => bcrypt('123456789'),
            'role' => 'admin'
        ]);
    }
}
