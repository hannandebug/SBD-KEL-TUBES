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
        Schema::create('group_detail', function (Blueprint $table) {
            $table->id('id_group_detail');
            $table->bigInteger('id_group');
            $table->timestamp('founded_date')->nullable();
            $table->string('group_timezone')->nullable();
            $table->string('join_mode')->nullable();
            $table->boolean('is_private')->default(false);
            $table->integer('leadership_members')->nullable();
            $table->integer('pending_members')->nullable();
            $table->bigInteger('id_member')->nullable();
            $table->string('host_name')->nullable();
            $table->longText('photo_album')->nullable();
            $table->longText('welcome_message')->nullable();
            $table->integer('total_ratings')->nullable();
            $table->timestamps();
            $table->foreign('id_group')->references('id_group')->on('group_list')->onDelete('cascade');
            $table->foreign('id_member')->references('id_member')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('group_detail');
    }
};
