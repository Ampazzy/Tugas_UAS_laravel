<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;

use App\Models\User;
use App\Models\Role;
use App\Models\Profile;
use App\Models\Category;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        $now = now();

        Role::insert([
            [
                'nama_role' => 'admin',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'nama_role' => 'guest',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);

        User::create([
            'role_id' => 1,
            'name' => 'bagas123',
            'email' => 'bagasrizkiyanto@gmail.com',
            'password' => bcrypt('admin123')
        ]);


        Profile::create([
            'user_id' => 1,
            'nama' => 'Bagas Rizkiyanto',
            'alamat' => 'Kelapa Dua',
            'no_hp' => '0895365145790'
        ]);

        Category::insert([
            [
                'kategori' => 'Fiksi',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'kategori' => 'Non Fiksi',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'kategori' => 'Komik',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'kategori' => 'Novel',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);

    }
}