<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $json = file_get_contents(database_path('seeders/events_data.json'));
        $data = json_decode($json, true);

        foreach ($data as $event) {
            // Clean up the data
            $event = array_map(function($value) {
                return ($value === '') ? null : $value;
            }, $event);

            DB::table('event_list')->insert([
                'id_event' => $event['id'],
                'id_group' => $event['id_group'] ?? null,
                'event_title' => $event['event_title'] ?? null,
                'event_type' => $event['event_type'] ?? null,
                'event_date' => $event['event_date'] ?? null,
                'event_description' => $event['event_description'] ?? null,
                'total_rsvps' => is_numeric($event['total_rsvps']) ? (int)$event['total_rsvps'] : null,
                'venue_name' => $event['venue_name'] ?? null,
                'venue_city' => $event['venue_city'] ?? null,
                'venue_country' => $event['venue_country'] ?? null,
                'event_photo' => $event['event_photo'] ?? null,
                'category' => $event['Category'] ?? null,
            ]);
        }
    }
}
