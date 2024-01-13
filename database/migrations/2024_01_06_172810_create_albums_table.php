<?php

use App\Enums\AlbumType;
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
        Schema::create('albums', function (Blueprint $table) {
            $table->uuid("id")->primary();
            $table->uuid("creator_id");
            $table->foreign('creator_id')->references('id')->on('users');
            $table->uuid("artist_id");
            $table->foreign('artist_id')->references('id')->on('artists');
            $table->string("name");
            $table->enum("type", array_column(AlbumType::cases(), 'value'));
            $table->integer("year");
            $table->string("cover")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('albums');
    }
};
