<?php

// database/seeders/AdminSeeder.php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('admins')->insert([
            'username' => 'superadmin',
            'password' => Hash::make('password123'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Contoh 5 user
        $users = [
            [
                'name' => 'User Satu',
                'no_rumah' => 'A1',
                'no_tlp' => '08976457853',
                'alamat' => 'Blok A1 no 23',
                'email' => 'user1@gmail.com',
                'password' => Hash::make('user123'),
                'role' => 'user',
            ],
            [
                'name' => 'User Dua',
                'no_rumah' => 'A2',
                'no_tlp' => '08976457764',
                'alamat' => 'Blok A2 no 23',
                'email' => 'user2@gmail.com',
                'password' => Hash::make('user123'),
                'role' => 'user',
            ],
            [
                'name' => 'User Tiga',
                'no_rumah' => 'A3',
                'no_tlp' => '08976458812',
                'alamat' => 'Blok A3 no 23',
                'email' => 'user3@gmail.com',
                'password' => Hash::make('user123'),
                'role' => 'user',
            ],
            [
                'name' => 'User Empat',
                'no_rumah' => 'A4',
                'no_tlp' => '08976498812',
                'alamat' => 'Blok A4 no 23',
                'email' => 'user4@gmail.com',
                'password' => Hash::make('user123'),
                'role' => 'user',
            ],
            [
                'name' => 'User Lima',
                'no_rumah' => 'A5',
                'no_tlp' => '08886458812',
                'alamat' => 'Blok A5 no 23',
                'email' => 'user5@gmail.com',
                'password' => Hash::make('user123'),
                'role' => 'user',
            ],
        ];
        foreach ($users as $user) {
            User::create($user);
        }
    }
}
