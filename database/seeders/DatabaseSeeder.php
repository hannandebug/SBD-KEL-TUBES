<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed in correct order respecting foreign key constraints
        $this->call([
            UserSeeder::class,
            TopicSeeder::class,
            GroupSeeder::class,
            GroupDetailSeeder::class,
            GroupTopicSeeder::class,
            MemberGroupSeeder::class,
            EventSeeder::class,
            ReviewSeeder::class,
        ]);
    }
}

