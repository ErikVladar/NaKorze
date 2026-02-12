<?php

namespace Database\Seeders;

use App\Models\City;
use Illuminate\Database\Seeder;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $csvFile = public_path('adresy/Adresy_reduced.csv');

        if (!file_exists($csvFile)) {
            return;
        }

        $handle = fopen($csvFile, 'r');
        if ($handle === false) {
            return;
        }

        fgetcsv($handle, 0, ';');

        $cities = [];
        $rowCount = 0;
        $seenNames = [];

        while (($data = fgetcsv($handle, 0, ';')) !== false) {
            if (count($data) >= 2) {
                $cityName = trim($data[0]);
                
                if (in_array($cityName, $seenNames)) {
                    continue;
                }
                
                $cities[] = [
                    'name' => $cityName,
                    'postal_code' => trim($data[1]),
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
                $seenNames[] = $cityName;
                $rowCount++;
            }
        }

        fclose($handle);

        City::insert($cities);
    }
}
