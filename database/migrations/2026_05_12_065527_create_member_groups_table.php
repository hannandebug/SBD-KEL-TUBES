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
        Schema::create('member_group', function (Blueprint $table) {
            $table->bigInteger('id_member');
            $table->bigInteger('id_group');
            $table->string('role')->nullable();
            $table->timestamp('joined_at')->nullable();
            $table->timestamps();
            $table->primary(['id_member', 'id_group']);
            $table->foreign('id_member')->references('id_member')->on('users')->onDelete('cascade');
            $table->foreign('id_group')->references('id_group')->on('group_list')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('member_group');
    }
};
