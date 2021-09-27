<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::insert([
            'name' => 'Admin',
            'email' => 'admin@udana.id',
            'password' => Hash::make('udana'),
            'role_id' => 1,
        ]);

        User::insert([
            'name' => 'fikri',
            'email' => 'fikri@fikri.com',
            'password' => Hash::make('fikrifikri'),
            'role_id' => 1,
        ]);
    }
}
