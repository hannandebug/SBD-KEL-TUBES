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
        Schema::create('reviews_list', function (Blueprint $table) {
            $table->bigInteger('id_review')->primary();
            $table->bigInteger('id_member');
            $table->bigInteger('id_event')->nullable();
            $table->bigInteger('id_group')->nullable();
            $table->integer('rating_given')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->foreign('id_member')->references('id_member')->on('users')->onDelete('cascade');
            $table->foreign('id_event')->references('id_event')->on('event_list')->onDelete('cascade');
            $table->foreign('id_group')->references('id_group')->on('group_list')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews_list');
    }
};
