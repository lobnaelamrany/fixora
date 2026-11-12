<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ServiceRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'reference_number',
        'customer_id',
        'provider_profile_id',
        'service_category_id',
        'service_title',
        'description',
        'customer_type',
        'company_name',
        'city',
        'address',
        'preferred_date',
        'preferred_time',
        'urgency_level',
        'status',
        'decline_reason',
        'cancellation_reason',
        'submitted_at',
        'accepted_at',
        'completed_at',
        'cancelled_at',
    ];

    protected $casts = [
        'preferred_date' => 'date',
        'preferred_time' => 'datetime:H:i',
        'submitted_at' => 'datetime',
        'accepted_at' => 'datetime',
        'completed_at' => 'datetime',
        'cancelled_at' => 'datetime',
    ];

    // Relations
    public function customer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function providerProfile(): BelongsTo
    {
        return $this->belongsTo(ProviderProfile::class);
    }

    public function serviceCategory(): BelongsTo
    {
        return $this->belongsTo(ServiceCategory::class);
    }

    public function attachments(): HasMany
    {
        return $this->hasMany(RequestAttachment::class);
    }

    public function statusHistory(): HasMany
    {
        return $this->hasMany(ServiceRequestStatusHistory::class)->latest();
    }

    public function conversation(): HasOne
    {
        return $this->hasOne(Conversation::class);
    }

    public function review(): HasOne
    {
        return $this->hasOne(Review::class);
    }

    // Scopes
    public function scopeForCustomer($query, int $customerId)
    {
        return $query->where('customer_id', $customerId);
    }

    public function scopeForProvider($query, int $providerProfileId)
    {
        return $query->where('provider_profile_id', $providerProfileId);
    }

    public function scopeWithStatus($query, string $status)
    {
        return $query->where('status', $status);
    }

    // Helpers
    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    public function isCompleted(): bool
    {
        return $this->status === 'completed';
    }

    public function canBeReviewed(): bool
    {
        return $this->isCompleted() && !$this->review()->exists();
    }
}
