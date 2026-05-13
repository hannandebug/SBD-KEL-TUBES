<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $json = file_get_contents(database_path('seeders/reviews_data.json'));
        $data = json_decode($json, true);

        // Get all valid user, event, and group IDs
        $validMembers = DB::table('users')->pluck('id_member')->toArray();
        $validEvents = DB::table('event_list')->pluck('id_event')->toArray();
        $validGroups = DB::table('group_list')->pluck('id_group')->toArray();

        foreach ($data as $review) {
            // Clean up the data
            $review = array_map(function($value) {
                return ($value === '') ? null : $value;
            }, $review);

            // Verify foreign keys exist before inserting
            if (!in_array($review['id_member'] ?? null, $validMembers)) {
                continue;
            }

            $id_event = $review['id_event'] ?? null;
            if ($id_event !== null && !in_array($id_event, $validEvents)) {
                $id_event = null; // Set to null if event doesn't exist
            }

            $id_group = $review['id_group'] ?? null;
            if ($id_group !== null && !in_array($id_group, $validGroups)) {
                $id_group = null; // Set to null if group doesn't exist
            }

            // Skip if no valid event or group to review
            if ($id_event === null && $id_group === null) {
                continue;
            }

            DB::table('reviews_list')->insert([
                'id_review' => $review['id_review'],
                'id_member' => $review['id_member'],
                'id_event' => $id_event,
                'id_group' => $id_group,
                'rating_given' => is_numeric($review['rating_given']) ? (int)$review['rating_given'] : null,
                'created_at' => $review['created_at'] ?? null,
            ]);
        }
    }
}
