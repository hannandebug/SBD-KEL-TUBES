<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MemberGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $json = file_get_contents(database_path('seeders/member_groups_data.json'));
        $data = json_decode($json, true);

        $seen = []; // Track (id_member, id_group) combinations to skip duplicates

        foreach ($data as $memberGroup) {
            // Clean up the data
            $memberGroup = array_map(function($value) {
                return ($value === '' || trim($value) === '') ? null : trim($value);
            }, $memberGroup);

            // Skip records without id_member or with invalid id_member (must be > 0)
            $id_member = isset($memberGroup['id_member']) ? (int)$memberGroup['id_member'] : 0;
            if ($id_member <= 0) {
                continue;
            }

            $id_group = $memberGroup['id_group'] ?? null;
            $key = "$id_member-$id_group";

            // Skip duplicate combinations
            if (isset($seen[$key])) {
                continue;
            }
            $seen[$key] = true;

            DB::table('member_group')->insert([
                'id_member' => $id_member,
                'id_group' => $id_group,
                'role' => $memberGroup['role'] ?? null,
                'joined_at' => $memberGroup['joined_at'] ?? null,
            ]);
        }
    }
}
