<?php

namespace Database\Seeders;

use App\Models\ServiceCategory;
use Illuminate\Database\Seeder;

class ServiceCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'slug' => 'electricity',
                'name' => [
                    'fr' => 'Électricité',
                    'en' => 'Electricity',
                    'de' => 'Elektrizität',
                ],
                'description' => [
                    'fr' => 'Installation et réparation électrique',
                    'en' => 'Electrical installation and repair',
                    'de' => 'Elektrische Installation und Reparatur',
                ],
                'icon' => 'bolt',
            ],
            [
                'slug' => 'plumbing',
                'name' => [
                    'fr' => 'Plomberie',
                    'en' => 'Plumbing',
                    'de' => 'Sanitär',
                ],
                'description' => [
                    'fr' => 'Réparation de fuites et installations',
                    'en' => 'Leak repair and installations',
                    'de' => 'Reparatur von Lecks und Installationen',
                ],
                'icon' => 'water',
            ],
            [
                'slug' => 'air-conditioning',
                'name' => [
                    'fr' => 'Climatisation',
                    'en' => 'Air Conditioning',
                    'de' => 'Klimaanlage',
                ],
                'description' => [
                    'fr' => 'Installation et entretien de climatisation',
                    'en' => 'AC installation and maintenance',
                    'de' => 'Klimaanlagen Installation und Wartung',
                ],
                'icon' => 'wind',
            ],
            [
                'slug' => 'heating',
                'name' => [
                    'fr' => 'Chauffage',
                    'en' => 'Heating',
                    'de' => 'Heizung',
                ],
                'description' => [
                    'fr' => 'Installation et réparation de chauffage',
                    'en' => 'Heating installation and repair',
                    'de' => 'Heizungsinstallation und -reparatur',
                ],
                'icon' => 'fire',
            ],
            [
                'slug' => 'appliances',
                'name' => [
                    'fr' => 'Électroménager',
                    'en' => 'Appliances',
                    'de' => 'Haushaltsgeräte',
                ],
                'description' => [
                    'fr' => 'Réparation d\'appareils ménagers',
                    'en' => 'Home appliance repair',
                    'de' => 'Reparatur von Haushaltsgeräten',
                ],
                'icon' => 'home',
            ],
            [
                'slug' => 'locksmith',
                'name' => [
                    'fr' => 'Serrurerie',
                    'en' => 'Locksmith',
                    'de' => 'Schlosser',
                ],
                'description' => [
                    'fr' => 'Ouverture de portes et serrures',
                    'en' => 'Door and lock opening',
                    'de' => 'Tür- und Schlossöffnung',
                ],
                'icon' => 'key',
            ],
            [
                'slug' => 'it-computer',
                'name' => [
                    'fr' => 'Informatique',
                    'en' => 'IT & Computer',
                    'de' => 'IT & Computer',
                ],
                'description' => [
                    'fr' => 'Réparation ordinateurs et réseaux',
                    'en' => 'Computer and network repair',
                    'de' => 'Computer- und Netzwerkreparatur',
                ],
                'icon' => 'computer',
            ],
            [
                'slug' => 'general-maintenance',
                'name' => [
                    'fr' => 'Maintenance générale',
                    'en' => 'General Maintenance',
                    'de' => 'Allgemeine Wartung',
                ],
                'description' => [
                    'fr' => 'Petits travaux et maintenance générale',
                    'en' => 'Small repairs and general maintenance',
                    'de' => 'Kleine Reparaturen und allgemeine Wartung',
                ],
                'icon' => 'tool',
            ],
        ];

        foreach ($categories as $category) {
            ServiceCategory::updateOrCreate(
                ['slug' => $category['slug']],
                $category
            );
        }
    }
}
