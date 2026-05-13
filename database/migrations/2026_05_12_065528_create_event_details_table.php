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
        Schema::create('event_detail', function (Blueprint $table) {
            $table->id('id_event_detail');
            $table->bigInteger('id_event');
            $table->string('event_status')->nullable();
            $table->timestamp('event_endtime')->nullable();
            $table->string('rsvp_state')->nullable();
            $table->string('venue_address')->nullable();
            $table->timestamps();
            $table->foreign('id_event')->references('id_event')->on('event_list')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_detail');
    }
};
