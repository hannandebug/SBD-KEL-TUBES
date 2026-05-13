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
        Schema::create('event_attendance', function (Blueprint $table) {
            $table->bigInteger('id_member');
            $table->bigInteger('id_event');
            $table->string('rsvps_status')->nullable();
            $table->timestamp('attended_at')->nullable();
            $table->timestamps();
            $table->primary(['id_member', 'id_event']);
            $table->foreign('id_member')->references('id_member')->on('users')->onDelete('cascade');
            $table->foreign('id_event')->references('id_event')->on('event_list')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_attendance');
    }
};
