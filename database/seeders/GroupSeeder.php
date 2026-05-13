<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $json = file_get_contents(database_path('seeders/groups_data.json'));
        $data = json_decode($json, true);

        foreach ($data as $group) {
            // Clean up the data
            $group = array_map(function($value) {
                return ($value === '') ? null : $value;
            }, $group);

            DB::table('group_list')->insert([
                'id_group' => $group['id_group'],
                'group_name' => $group['group_name'] ?? null,
                'group_description' => $group['group_description'] ?? null,
                'city' => $group['city'] ?? null,
                'country' => $group['country'] ?? null,
                'is_newgroup' => strtolower($group['is_newgroup'] ?? 'false') === 'true' || $group['is_newgroup'] === 1,
                'member_count' => is_numeric($group['member_count']) ? (int)$group['member_count'] : null,
                'group_photo' => $group['group_photo'] ?? null,
                'average_rating' => is_numeric($group['average_rating']) ? (float)$group['average_rating'] : null,
                'category' => $group['category'] ?? null,
            ]);
        }
    }
}
