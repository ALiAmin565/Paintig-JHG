<?php

namespace Database\Seeders;

use App\Models\Hotel;
use Illuminate\Database\Seeder;

class NewHotelsSeeder extends Seeder
{
    public function run(): void
    {
        $newHotels = [
            ['name' => 'Jaz Viva Casa Maza', 'pms_code' => '017-CASA'],
            ['name' => 'JAZ Viva Villagio', 'pms_code' => '017-VILL'],
            ['name' => 'Almaza Blue Jaz', 'pms_code' => '017-ALB'],
            ['name' => 'Sakhra', 'pms_code' => 'H40'],
        ];

        foreach ($newHotels as $hotelData) {
            Hotel::updateOrCreate(
                ['pms_code' => $hotelData['pms_code']],
                ['name' => $hotelData['name'], 'status' => 'active']
            );
        }

        $this->command->info('Added ' . count($newHotels) . ' new hotels successfully!');
    }
}