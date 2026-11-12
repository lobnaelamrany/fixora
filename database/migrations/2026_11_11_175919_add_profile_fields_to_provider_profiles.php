<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('provider_profiles', function (Blueprint $table) {
            $table->string('cover_photo')->nullable()->after('profile_photo');
            $table->string('phone')->nullable()->after('description');
            $table->string('whatsapp')->nullable()->after('phone');
            $table->json('languages')->nullable()->after('whatsapp');
            $table->boolean('is_available_now')->default(false)->after('languages');
        });
    }

    public function down(): void
    {
        Schema::table('provider_profiles', function (Blueprint $table) {
            $table->dropColumn(['cover_photo', 'phone', 'whatsapp', 'languages', 'is_available_now']);
        });
    }
};
