<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GroupDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $json = file_get_contents(database_path('seeders/group_details_data.json'));
        $data = json_decode($json, true);

        foreach ($data as $detail) {
            // Clean up the data
            $detail = array_map(function($value) {
                return ($value === '' || $value === 'Not Available') ? null : $value;
            }, $detail);

            // Only insert if id_group_detail exists
            if (!isset($detail['id_group_detail'])) {
                continue;
            }

            // Handle id_member - skip if it's not a valid number
            $id_member = null;
            if (isset($detail['id_member']) && !empty($detail['id_member'])) {
                $id_member = is_numeric($detail['id_member']) ? (int)$detail['id_member'] : null;
            }

            DB::table('group_detail')->insert([
                'id_group_detail' => $detail['id_group_detail'],
                'id_group' => $detail['id_group'] ?? null,
                'founded_date' => $detail['founded_date'] ?? null,
                'group_timezone' => $detail['group_timezone'] ?? null,
                'join_mode' => $detail['join_mode'] ?? null,
                'is_private' => strtolower($detail['is_private'] ?? 'false') === 'true' || $detail['is_private'] === 1 ? true : false,
                'leadership_members' => is_numeric($detail['leadership_members']) ? (int)$detail['leadership_members'] : null,
                'pending_members' => is_numeric($detail['pending_members']) ? (int)$detail['pending_members'] : null,
                'id_member' => $id_member,
                'host_name' => $detail['host_name'] ?? null,
                'photo_album' => $detail['photo_album'] ?? null,
                'welcome_message' => $detail['welcome_message'] ?? null,
                'total_ratings' => is_numeric($detail['total_ratings']) ? (int)$detail['total_ratings'] : null,
            ]);
        }
    }
}
