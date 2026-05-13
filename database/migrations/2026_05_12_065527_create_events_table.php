<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('event_list', function (Blueprint $table) {
            $table->bigInteger('id_event')->primary();
            $table->bigInteger('id_group')->nullable();
            $table->string('event_title')->nullable();
            $table->string('event_type')->nullable();
            $table->timestamp('event_date')->nullable();
            $table->longText('event_description')->nullable();
            $table->integer('total_rsvps')->nullable();
            $table->string('venue_name')->nullable();
            $table->string('venue_city')->nullable();
            $table->string('venue_country')->nullable();
            $table->string('event_photo')->nullable();
            $table->string('category')->nullable();
            $table->timestamps();
            $table->foreign('id_group')->references('id_group')->on('group_list')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_list');
    }
};
