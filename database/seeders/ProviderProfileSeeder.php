<?php

namespace Database\Seeders;

use App\Models\ProviderAvailability;
use App\Models\ProviderProfile;
use App\Models\ServiceArea;
use App\Models\ServiceCategory;
use App\Models\User;
use Illuminate\Database\Seeder;

class ProviderProfileSeeder extends Seeder
{
    public function run(): void
    {
        $pro1 = User::where('email', 'pro1@fixora.test')->first();
        $pro2 = User::where('email', 'pro2@fixora.test')->first();

        // Professional 1 - Electrician
        if ($pro1) {
            $profile1 = ProviderProfile::updateOrCreate(
                ['user_id' => $pro1->id],
                [
                    'business_name' => 'Ahmed Élec',
                    'profile_photo' => 'https://i.pravatar.cc/300?img=12',
                    'cover_photo' => 'https://images.unsplash.com/photo-1621905251189-08b45d6a269e?w=1200',
                    'description' => 'Électricien professionnel avec 10 ans d\'expérience. Spécialisé dans l\'installation, la réparation et la maintenance électrique pour particuliers et entreprises. Intervention rapide à Casablanca et Rabat.',
                    'experience_years' => 10,
                    'verification_status' => 'verified',
                    'average_rating' => 4.8,
                    'completed_services_count' => 127,
                    'phone' => '+212 6 12 34 56 78',
                    'whatsapp' => '+212612345678',
                    'languages' => ['Français', 'العربية', 'English'],
                    'is_available_now' => true,
                ]
            );

            $electricity = ServiceCategory::where('slug', 'electricity')->first();
            if ($electricity) {
                $profile1->services()->syncWithoutDetaching([$electricity->id]);
            }

            $casablanca = ServiceArea::where('city', 'Casablanca')->first();
            $rabat = ServiceArea::where('city', 'Rabat')->first();
            if ($casablanca) $profile1->areas()->syncWithoutDetaching([$casablanca->id]);
            if ($rabat) $profile1->areas()->syncWithoutDetaching([$rabat->id]);

            for ($day = 1; $day <= 5; $day++) {
                ProviderAvailability::updateOrCreate(
                    ['provider_profile_id' => $profile1->id, 'day_of_week' => $day],
                    ['start_time' => '09:00:00', 'end_time' => '18:00:00', 'is_available' => true]
                );
            }
        }

        // Professional 2 - Plumber
        if ($pro2) {
            $profile2 = ProviderProfile::updateOrCreate(
                ['user_id' => $pro2->id],
                [
                    'business_name' => 'Karim Plomberie',
                    'profile_photo' => 'https://i.pravatar.cc/300?img=33',
                    'cover_photo' => 'https://images.unsplash.com/photo-1585704032915-c3400ca199e7?w=1200',
                    'description' => 'Plombier expérimenté, disponible à Casablanca et Marrakech. Spécialiste des fuites, installations sanitaires et dépannages urgents.',
                    'experience_years' => 7,
                    'verification_status' => 'verified',
                    'average_rating' => 4.6,
                    'completed_services_count' => 89,
                    'phone' => '+212 6 98 76 54 32',
                    'whatsapp' => '+212698765432',
                    'languages' => ['Français', 'العربية'],
                    'is_available_now' => false,
                ]
            );

            $plumbing = ServiceCategory::where('slug', 'plumbing')->first();
            if ($plumbing) {
                $profile2->services()->syncWithoutDetaching([$plumbing->id]);
            }

            $casablanca = ServiceArea::where('city', 'Casablanca')->first();
            $marrakech = ServiceArea::where('city', 'Marrakech')->first();
            if ($casablanca) $profile2->areas()->syncWithoutDetaching([$casablanca->id]);
            if ($marrakech) $profile2->areas()->syncWithoutDetaching([$marrakech->id]);

            for ($day = 1; $day <= 6; $day++) {
                ProviderAvailability::updateOrCreate(
                    ['provider_profile_id' => $profile2->id, 'day_of_week' => $day],
                    ['start_time' => '08:00:00', 'end_time' => '19:00:00', 'is_available' => true]
                );
            }
        }
    }
}
