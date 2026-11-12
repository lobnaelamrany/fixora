<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class ServiceArea extends Model
{
    use HasFactory;

    protected $fillable = [
        'city',
        'region',
        'country_code',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function providers(): BelongsToMany
    {
        return $this->belongsToMany(
            ProviderProfile::class,
            'provider_service_areas',
            'service_area_id',
            'provider_profile_id'
        )->withTimestamps();
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
