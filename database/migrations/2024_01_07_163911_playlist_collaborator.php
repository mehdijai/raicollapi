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
        Schema::create('playlist_collaborator', function (Blueprint $table) {
            $table->uuid("id")->primary();
            $table->uuid("creator_id");
            $table->foreign('creator_id')->references('id')->on('users');
            $table->uuid("playlist_id");
            $table->foreign('playlist_id')->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('playlist_collaborator');
    }
};
