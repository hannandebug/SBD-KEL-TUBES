<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $json = file_get_contents(database_path('seeders/users_data.json'));
        $data = json_decode($json, true);

        foreach ($data as $user) {
            // Clean up the data
            $user = array_map(function($value) {
                return ($value === '' || $value === null) ? null : $value;
            }, $user);

            DB::table('users')->insert([
                'id_member' => $user['id_member'],
                'member_name' => $user['member_name'] ?? null,
                'member_email' => $user['member_email'] ?? null,
                'member_city' => $user['member_city'] ?? null,
                'member_country' => $user['member_country'] ?? null,
                'member_gr_count' => is_numeric($user['member_gr_count']) ? (int)$user['member_gr_count'] : null,
                'member_ev_count' => is_numeric($user['member_ev_count']) ? (int)$user['member_ev_count'] : null,
                'created_at' => $user['created_at'] ?? null,
            ]);
        }
    }
}
