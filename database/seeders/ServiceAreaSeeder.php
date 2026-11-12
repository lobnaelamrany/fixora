<?php

namespace Database\Seeders;

use App\Models\ServiceArea;
use Illuminate\Database\Seeder;

class ServiceAreaSeeder extends Seeder
{
    public function run(): void
    {
        $areas = [
            ['city' => 'Casablanca', 'region' => 'Casablanca-Settat'],
            ['city' => 'Rabat', 'region' => 'Rabat-Salé-Kénitra'],
            ['city' => 'Marrakech', 'region' => 'Marrakech-Safi'],
            ['city' => 'Fès', 'region' => 'Fès-Meknès'],
            ['city' => 'Tanger', 'region' => 'Tanger-Tétouan-Al Hoceïma'],
            ['city' => 'Agadir', 'region' => 'Souss-Massa'],
            ['city' => 'Meknès', 'region' => 'Fès-Meknès'],
            ['city' => 'Oujda', 'region' => 'Oriental'],
            ['city' => 'Kénitra', 'region' => 'Rabat-Salé-Kénitra'],
            ['city' => 'Tétouan', 'region' => 'Tanger-Tétouan-Al Hoceïma'],
            ['city' => 'Salé', 'region' => 'Rabat-Salé-Kénitra'],
            ['city' => 'Mohammedia', 'region' => 'Casablanca-Settat'],
        ];

        foreach ($areas as $area) {
            ServiceArea::updateOrCreate(
                ['city' => $area['city'], 'country_code' => 'MA'],
                $area + ['country_code' => 'MA']
            );
        }
    }
}
