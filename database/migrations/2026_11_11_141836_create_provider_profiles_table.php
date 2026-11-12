<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('provider_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained()->cascadeOnDelete();
            $table->string('business_name')->nullable();
            $table->string('profile_photo')->nullable();
            $table->text('description')->nullable();
            $table->unsignedTinyInteger('experience_years')->default(0);
            $table->enum('verification_status', ['pending', 'verified', 'rejected'])->default('pending');
            $table->decimal('average_rating', 3, 2)->default(0);
            $table->unsignedInteger('completed_services_count')->default(0);
            $table->timestamps();

            $table->index('verification_status');
            $table->index('average_rating');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('provider_profiles');
    }
};
