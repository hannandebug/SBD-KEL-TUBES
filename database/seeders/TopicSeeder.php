<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TopicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $json = file_get_contents(database_path('seeders/topics_data.json'));
        $data = json_decode($json, true);

        foreach ($data as $topic) {
            DB::table('topic')->insert([
                'id_topic' => $topic['id_topic'],
                'topic_name' => $topic['topic_name'] ?? null,
            ]);
        }
    }
}
