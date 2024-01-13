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
        Schema::create('tracks', function (Blueprint $table) {
            $table->uuid("id")->primary();
            $table->uuid("creator_id");
            $table->foreign('creator_id')->references('id')->on('users');
            $table->uuid("album_id");
            $table->foreign('album_id')->references('id')->on('albums');
            $table->string("filePath");
            $table->string("title");
            $table->integer("year");
            $table->integer("trackNb");
            $table->string("genres");
            $table->string("cover")->nullable();
            $table->string("mimetype");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tracks');
    }
};
