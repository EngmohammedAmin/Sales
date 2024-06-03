<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;

class CreateAdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Admin::create([
            'name' => 'Mohammed Amin',
            'email' => 'alathoriyemen@gmail.com',
            'user_name' => 'Admin',
            'password' => bcrypt('12345678'),
            'com_code' => 1,
        ]);
    }
}
