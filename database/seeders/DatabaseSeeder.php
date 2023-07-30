<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
         User::factory()->create([
            'nama_lengkap' => 'Admin',
            'username' => 'admin',
            'email' => 'admin@material.com',
            'password' => ('secret')
        ]);
    }
}
