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
        $cities = [
            ['name' => 'Bratislava', 'postal_code' => '811 01'],
            ['name' => 'Devínska Nová Ves', 'postal_code' => '900 01'],
            ['name' => 'Borinka', 'postal_code' => '900 02'],
            ['name' => 'Dubová', 'postal_code' => '900 05'],
            ['name' => 'Carnúch', 'postal_code' => '900 06'],
            ['name' => 'Rusovce', 'postal_code' => '900 07'],
            ['name' => 'Stupava', 'postal_code' => '900 31'],
            ['name' => 'Záhorská Bystrica', 'postal_code' => '900 51'],
            ['name' => 'Vysoká pri Morave', 'postal_code' => '900 54'],
            ['name' => 'Suchohrad', 'postal_code' => '900 61'],
            ['name' => 'Pezinok', 'postal_code' => '902 01'],
            ['name' => 'Modra', 'postal_code' => '900 01'],
            ['name' => 'Svätý Jur', 'postal_code' => '900 21'],
            ['name' => 'Vrbové', 'postal_code' => '900 41'],
            ['name' => 'Moravský Svätý Ján', 'postal_code' => '900 71'],
            ['name' => 'Velký Kýr', 'postal_code' => '900 81'],
            
            ['name' => 'Trnava', 'postal_code' => '917 01'],
            ['name' => 'Sereď', 'postal_code' => '925 01'],
            ['name' => 'Galanta', 'postal_code' => '924 01'],
            ['name' => 'Dunajská Streda', 'postal_code' => '929 01'],
            ['name' => 'Hlohovec', 'postal_code' => '920 01'],
            ['name' => 'Šoporňa', 'postal_code' => '919 01'],
            ['name' => 'Leopoldov', 'postal_code' => '916 01'],
            ['name' => 'Piešťany', 'postal_code' => '921 01'],
            ['name' => 'Gbely', 'postal_code' => '908 01'],
            ['name' => 'Skalica', 'postal_code' => '909 01'],
            ['name' => 'Holíč', 'postal_code' => '915 01'],
            ['name' => 'Senica', 'postal_code' => '905 01'],
            ['name' => 'Šamorín', 'postal_code' => '932 01'],
            ['name' => 'Vráble', 'postal_code' => '957 01'],
            
            ['name' => 'Trenčín', 'postal_code' => '911 01'],
            ['name' => 'Prievidza', 'postal_code' => '971 01'],
            ['name' => 'Partizánske', 'postal_code' => '958 01'],
            ['name' => 'Nováky', 'postal_code' => '972 01'],
            ['name' => 'Handlová', 'postal_code' => '973 01'],
            ['name' => 'Bytča', 'postal_code' => '913 01'],
            ['name' => 'Beňová', 'postal_code' => '914 01'],
            ['name' => 'Dubnica nad Váhom', 'postal_code' => '018 01'],
            ['name' => 'Ilava', 'postal_code' => '019 01'],
            ['name' => 'Myjava', 'postal_code' => '906 01'],
            ['name' => 'Stará Turá', 'postal_code' => '917 41'],
            ['name' => 'Puchov', 'postal_code' => '911 26'],
            ['name' => 'Chocnú', 'postal_code' => '910 01'],
            
            ['name' => 'Nitra', 'postal_code' => '949 01'],
            ['name' => 'Komárno', 'postal_code' => '945 01'],
            ['name' => 'Levice', 'postal_code' => '934 01'],
            ['name' => 'Topoľčany', 'postal_code' => '955 01'],
            ['name' => 'Párkány', 'postal_code' => '943 01'],
            ['name' => 'Štúrovo', 'postal_code' => '945 01'],
            ['name' => 'Želiezovce', 'postal_code' => '948 01'],
            ['name' => 'Zvolenská Slatina', 'postal_code' => '960 01'],
            ['name' => 'Vrábeľ', 'postal_code' => '957 01'],
            ['name' => 'Veľký Krtíš', 'postal_code' => '966 01'],
            ['name' => 'Tlmače', 'postal_code' => '951 01'],
            ['name' => 'Tekovská Bychloritva', 'postal_code' => '951 01'],
            
            ['name' => 'Žilina', 'postal_code' => '010 01'],
            ['name' => 'Čunovo', 'postal_code' => '020 01'],
            ['name' => 'Dolný Kubín', 'postal_code' => '026 01'],
            ['name' => 'Tvrdošín', 'postal_code' => '027 01'],
            ['name' => 'Kysucké Nové Mesto', 'postal_code' => '023 01'],
            ['name' => 'Čadca', 'postal_code' => '022 01'],
            ['name' => 'Rajec', 'postal_code' => '017 01'],
            ['name' => 'Liptovský Mikuláš', 'postal_code' => '031 01'],
            ['name' => 'Ružomberok', 'postal_code' => '034 01'],
            ['name' => 'Liptovský Hrádok', 'postal_code' => '033 01'],
            ['name' => 'Turčianske Teplice', 'postal_code' => '038 01'],
            ['name' => 'Martin', 'postal_code' => '036 01'],
            ['name' => 'Turčiansk Suchá', 'postal_code' => '040 01'],
            ['name' => 'Vrútky', 'postal_code' => '038 51'],
            
            ['name' => 'Banská Bystrica', 'postal_code' => '974 01'],
            ['name' => 'Zvolen', 'postal_code' => '960 01'],
            ['name' => 'Banská Štiavnica', 'postal_code' => '969 01'],
            ['name' => 'Kremnica', 'postal_code' => '967 01'],
            ['name' => 'Detva', 'postal_code' => '962 01'],
            ['name' => 'Fiľakovo', 'postal_code' => '981 01'],
            ['name' => 'Poltár', 'postal_code' => '982 01'],
            ['name' => 'Brezno', 'postal_code' => '977 01'],
            ['name' => 'Hnúšťa', 'postal_code' => '979 01'],
            ['name' => 'Žarnovica', 'postal_code' => '969 01'],
            ['name' => 'Zvolská Slatina', 'postal_code' => '960 01'],
            ['name' => 'Krupina', 'postal_code' => '965 01'],
            ['name' => 'Žiar nad Hronom', 'postal_code' => '965 81'],
            
            ['name' => 'Košice', 'postal_code' => '040 01'],
            ['name' => 'Prešov', 'postal_code' => '080 01'],
            ['name' => 'Michalovce', 'postal_code' => '071 01'],
            ['name' => 'Bardejov', 'postal_code' => '085 01'],
            ['name' => 'Vranov nad Topľou', 'postal_code' => '083 01'],
            ['name' => 'Medzilaborce', 'postal_code' => '082 01'],
            ['name' => 'Kežmarok', 'postal_code' => '060 01'],
            ['name' => 'Spišská Nová Ves', 'postal_code' => '052 01'],
            ['name' => 'Poprad', 'postal_code' => '058 01'],
            ['name' => 'Stará Ľubovňa', 'postal_code' => '064 01'],
            ['name' => 'Levoča', 'postal_code' => '054 01'],
            ['name' => 'Gelnica', 'postal_code' => '049 01'],
            ['name' => 'Rožňava', 'postal_code' => '048 01'],
            ['name' => 'Moldava nad Bodvou', 'postal_code' => '049 31'],
            ['name' => 'Sobrance', 'postal_code' => '073 01'],
            ['name' => 'Trebišov', 'postal_code' => '075 01'],
            ['name' => 'Spišský Štvrtok', 'postal_code' => '053 01'],
            ['name' => 'Spišský Šväty Jur', 'postal_code' => '053 01'],
            ['name' => 'Pečovská Nová Ves', 'postal_code' => '046 01'],
            
            ['name' => 'Svidník', 'postal_code' => '089 01'],
            ['name' => 'Humenné', 'postal_code' => '066 01'],
            ['name' => 'Stropkov', 'postal_code' => '090 01'],
            ['name' => 'Giraltovce', 'postal_code' => '091 01'],
            
            ['name' => 'Bielsko', 'postal_code' => '962 01'],
        ];

        // Remove duplicates while preserving keys
        $unique_cities = [];
        $seen_names = [];
        
        foreach ($cities as $city) {
            if (!in_array($city['name'], $seen_names)) {
                $unique_cities[] = $city;
                $seen_names[] = $city['name'];
            }
        }

        // Insert cities
        foreach ($unique_cities as $city) {
            City::firstOrCreate(
                ['name' => $city['name']],
                ['postal_code' => $city['postal_code']]
            );
        }
    }
}
