<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('service_requests', function (Blueprint $table) {
            $table->id();
            $table->string('reference_number')->unique();
            $table->foreignId('customer_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('provider_profile_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('service_category_id')->constrained()->restrictOnDelete();
            $table->string('service_title');
            $table->text('description');
            $table->enum('customer_type', ['individual', 'business'])->default('individual');
            $table->string('company_name')->nullable();
            $table->string('city');
            $table->string('address');
            $table->date('preferred_date')->nullable();
            $table->time('preferred_time')->nullable();
            $table->enum('urgency_level', ['normal', 'urgent'])->default('normal');
            $table->enum('status', [
                'pending', 'accepted', 'declined', 'in_progress', 'completed', 'cancelled'
            ])->default('pending');
            $table->text('decline_reason')->nullable();
            $table->text('cancellation_reason')->nullable();
            $table->timestamp('submitted_at')->nullable();
            $table->timestamp('accepted_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamp('cancelled_at')->nullable();
            $table->timestamps();

            $table->index(['customer_id', 'status']);
            $table->index(['provider_profile_id', 'status']);
            $table->index(['service_category_id', 'city', 'status']);
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('service_requests');
    }
};
