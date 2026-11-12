<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class ProviderProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'business_name',
        'profile_photo',
        'cover_photo',
        'description',
        'experience_years',
        'verification_status',
        'average_rating',
        'completed_services_count',
        'phone',
        'whatsapp',
        'languages',
        'is_available_now',
    ];

    protected $casts = [
        'average_rating' => 'decimal:2',
        'experience_years' => 'integer',
        'completed_services_count' => 'integer',
        'languages' => 'array',
        'is_available_now' => 'boolean',
    ];

    // ==================== Relations ====================

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function services(): BelongsToMany
    {
        return $this->belongsToMany(
            ServiceCategory::class,
            'provider_services',
            'provider_profile_id',
            'service_category_id'
        )->withTimestamps();
    }

    public function areas(): BelongsToMany
    {
        return $this->belongsToMany(
            ServiceArea::class,
            'provider_service_areas',
            'provider_profile_id',
            'service_area_id'
        )->withTimestamps();
    }

    public function availabilities(): HasMany
    {
        return $this->hasMany(ProviderAvailability::class);
    }

    public function serviceRequests(): HasMany
    {
        return $this->hasMany(ServiceRequest::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function conversations(): HasMany
    {
        return $this->hasMany(Conversation::class);
    }

    // ==================== Accessors ====================

    public function getProfilePhotoUrlAttribute(): ?string
    {
        if (!$this->profile_photo) {
            return null;
        }

        if (str_starts_with($this->profile_photo, 'http')) {
            return $this->profile_photo;
        }

        return Storage::url($this->profile_photo);
    }

    public function getCoverPhotoUrlAttribute(): ?string
    {
        if (!$this->cover_photo) {
            return null;
        }

        if (str_starts_with($this->cover_photo, 'http')) {
            return $this->cover_photo;
        }

        return Storage::url($this->cover_photo);
    }

    public function getDisplayNameAttribute(): string
    {
        return $this->business_name ?: $this->user->name;
    }

    // ==================== Helpers ====================

    public function isVerified(): bool
    {
        return $this->verification_status === 'verified';
    }

    public function offersService(int $categoryId): bool
    {
        return $this->services()->where('service_categories.id', $categoryId)->exists();
    }

    public function coversCity(string $city): bool
    {
        return $this->areas()->where('city', $city)->exists();
    }

    public function isAvailableOnDay(int $dayOfWeek): bool
    {
        return $this->availabilities()
            ->where('day_of_week', $dayOfWeek)
            ->where('is_available', true)
            ->exists();
    }
}
