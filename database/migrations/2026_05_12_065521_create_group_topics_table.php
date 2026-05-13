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
        Schema::create('group_topic', function (Blueprint $table) {
            $table->bigInteger('id_group');
            $table->bigInteger('id_topic');
            $table->timestamps();
            $table->primary(['id_group', 'id_topic']);
            $table->foreign('id_group')->references('id_group')->on('group_list')->onDelete('cascade');
            $table->foreign('id_topic')->references('id_topic')->on('topic')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('group_topic');
    }
};
