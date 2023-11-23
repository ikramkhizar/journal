<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'id'         => 1,
                'role'       => 'admin',
                'name'       => 'Admin',
                'email'      => 'admin@journal.test',
                'password'   => \Hash::make('password'),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id'         => 2,
                'role'       => 'user',
                'name'       => 'Ikram Khizer',
                'email'      => 'ikramkhizer@journal.test',
                'password'   => \Hash::make('password'),
                'created_at' => now(),
                'updated_at' => now()
            ],
        ];

        User::insert($users);
    }
}
