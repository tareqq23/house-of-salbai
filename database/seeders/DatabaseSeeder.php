<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Supaya tidak terjadi error duplikat jika dieksekusi berulang
        User::firstOrCreate(
            ['email' => 'admin@salbai.com'],
            [
                'name' => 'Administrator HOS',
                'password' => Hash::make('skripsi123') // Ini kata sandinya
            ]
        );
    }
}
