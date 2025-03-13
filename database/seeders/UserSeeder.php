<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'ilyass',
            'email' => 'ilyass@gmail.com',
            'password' => '123456789',
        ]);

        User::factory()->create([
            'name' => 'ayman',
            'email' => 'ayman@gmail.com',
            'password' => '123456789',
        ]);

        User::factory()->create([
            'name' => 'nabil',
            'email' => 'nabil@gmail.com',
            'password' => '123456789',
        ]);
        
    }
}
