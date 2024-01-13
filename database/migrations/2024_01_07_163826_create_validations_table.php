<?php

use App\Enums\ValidationStatus;
use App\Enums\ValidationTypes;
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
        Schema::create('validations', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->enum('type', array_column(ValidationTypes::cases(), 'value'));
            $table->enum('status', array_column(ValidationStatus::cases(), 'value'));
            $table->text('description');
            $table->uuid('validator_id');
            $table->foreign('validator_id')->references('id')->on('users');
            $table->uuid('validateable_id');
            $table->string('validateable_type');
            $table->dateTime('validated_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('validations');
    }
};
