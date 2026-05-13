<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GroupTopicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $json = file_get_contents(database_path('seeders/group_topics_data.json'));
        $data = json_decode($json, true);

        foreach ($data as $groupTopic) {
            DB::table('group_topic')->insert([
                'id_group' => $groupTopic['id_group'],
                'id_topic' => $groupTopic['id_topic'],
            ]);
        }
    }
}
