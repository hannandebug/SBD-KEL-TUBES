<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        if (!User::where('member_email', 'admin@meetup.com')->exists()) {
            User::create([
                'id_member' => 1,
                'name' => 'Admin',
                'member_name' => 'Admin',
                'member_email' => 'admin@meetup.com',
                'email' => 'admin@meetup.com',
                'password' => Hash::make('admin123'),
                'member_city' => 'Jakarta',
                'member_country' => 'Indonesia',
                'member_gr_count' => 0,
                'member_ev_count' => 0,
            ]);
        }
    }
}
