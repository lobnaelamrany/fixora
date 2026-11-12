<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('provider_service_areas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('provider_profile_id')->constrained()->cascadeOnDelete();
            $table->foreignId('service_area_id')->constrained()->cascadeOnDelete();
            $table->timestamps();

            $table->unique(['provider_profile_id', 'service_area_id'], 'provider_area_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('provider_service_areas');
    }
};
