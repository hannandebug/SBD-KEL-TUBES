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
        Schema::create('group_list', function (Blueprint $table) {
            $table->bigInteger('id_group')->primary();
            $table->string('group_name')->nullable();
            $table->longText('group_description')->nullable();
            $table->string('city')->nullable();
            $table->string('country')->nullable();
            $table->boolean('is_newgroup')->default(false);
            $table->integer('member_count')->nullable();
            $table->string('group_photo')->nullable();
            $table->float('average_rating')->nullable();
            $table->string('category')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('group_list');
    }
};
