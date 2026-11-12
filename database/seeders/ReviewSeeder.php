<?php

namespace Database\Seeders;

use App\Models\ProviderProfile;
use App\Models\ServiceRequest;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ReviewSeeder extends Seeder
{
    public function run(): void
    {
        $customers = User::where('role', 'customer')->get();
        $providers = ProviderProfile::all();

        if ($customers->isEmpty() || $providers->isEmpty()) {
            return;
        }

        $comments = [
            'Excellent travail, très professionnel et rapide. Je recommande vivement!',
            'Intervention rapide et efficace. Prix raisonnable. Merci!',
            'Très bon contact, travail soigné. Je ferai appel à ses services à nouveau.',
            'Professionnel sérieux et à l\'écoute. Résultat impeccable.',
            'Rapide, efficace et sympathique. Un vrai plaisir de travailler avec lui.',
            'Bon travail dans l\'ensemble. Petit retard mais résultat au top.',
        ];

        foreach ($providers as $provider) {
            for ($i = 0; $i < 5; $i++) {
                $customer = $customers->random();

                $request = ServiceRequest::create([
                    'reference_number' => 'FXR-SEED-'.strtoupper(Str::random(8)),
                    'customer_id' => $customer->id,
                    'provider_profile_id' => $provider->id,
                    'service_category_id' => $provider->services->first()?->id ?? 1,
                    'service_title' => 'Service request',
                    'description' => 'Completed service for review.',
                    'customer_type' => 'individual',
                    'city' => 'Casablanca',
                    'address' => '123 Test Street',
                    'urgency_level' => 'normal',
                    'status' => 'completed',
                    'submitted_at' => now()->subDays(rand(10, 60)),
                    'accepted_at' => now()->subDays(rand(8, 55)),
                    'completed_at' => now()->subDays(rand(1, 50)),
                ]);

                $request->review()->create([
                    'customer_id' => $customer->id,
                    'provider_profile_id' => $provider->id,
                    'rating' => rand(4, 5),
                    'comment' => $comments[array_rand($comments)],
                ]);
            }

            $avg = $provider->reviews()->avg('rating');
            $provider->update([
                'average_rating' => round($avg, 2),
                'completed_services_count' => $provider->reviews()->count(),
            ]);
        }
    }
}
