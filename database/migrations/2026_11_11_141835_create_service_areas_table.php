<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('service_areas', function (Blueprint $table) {
            $table->id();
            $table->string('city');
            $table->string('region')->nullable();
            $table->string('country_code', 2)->default('MA');
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->unique(['city', 'country_code']);
            $table->index('is_active');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('service_areas');
    }
};
