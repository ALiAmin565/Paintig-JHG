<?php

namespace Database\Seeders;

use App\Models\Hotel;
use Illuminate\Database\Seeder;

class HotelSeeder extends Seeder
{
    public function run(): void
    {
        $hotels = [
            ['name' => 'Palace Iberotel', 'pms_code' => '001'],
            ['name' => 'Fanara Resort Jaz', 'pms_code' => '004'],
            ['name' => 'Fanara Residence Jaz', 'pms_code' => '005'],
            ['name' => 'Belvedere Jaz', 'pms_code' => '002'],
            ['name' => 'Sharksbay Solymar', 'pms_code' => '026'],
            ['name' => 'Mirabel (Grand Total)', 'pms_code' => '003'],
            ['name' => 'Neo Neama Bay', 'pms_code' => '052'],
            ['name' => 'Steigenberger Alcazar', 'pms_code' => '572'],
            ['name' => 'Sharm Dreams Resort', 'pms_code' => 'M02'],
            ['name' => 'Fayrouz Resort', 'pms_code' => 'M03'],
            ['name' => 'Magic World Sharm', 'pms_code' => '35'],
            ['name' => 'Dahabeya Jaz', 'pms_code' => '006'],
            ['name' => 'Makadi Beach Iberotel', 'pms_code' => '015'],
            ['name' => 'Makadina Jaz', 'pms_code' => '010'],
            ['name' => 'Makadi Oasis Resort Jaz', 'pms_code' => '013'],
            ['name' => 'Makadi Oasis Club Jaz', 'pms_code' => '014'],
            ['name' => 'TUI BLUE Makadi Gardens', 'pms_code' => '012'],
            ['name' => 'TUI BLUE Makadi', 'pms_code' => '011'],
            ['name' => 'Makadi Saraya Jaz', 'pms_code' => '007'],
            ['name' => 'Makadi Star Resort and Spa Jaz', 'pms_code' => '008'],
            ['name' => 'Steigenberger Makadi', 'pms_code' => '051'],
            ['name' => 'Aquaviva Jaz', 'pms_code' => '028'],
            ['name' => 'Makadi Saraya Palms Jaz', 'pms_code' => '027'],
            ['name' => 'Ivory Suites Solymar', 'pms_code' => '023'],
            ['name' => 'Aquamarine Jaz', 'pms_code' => '025'],
            ['name' => 'Casa Del Mar Resort Jaz', 'pms_code' => '029'],
            ['name' => 'Coraya Beach Steigenberger', 'pms_code' => '018'],
            ['name' => 'Solaya Jaz', 'pms_code' => '020'],
            ['name' => 'Dar Elmadina Jaz', 'pms_code' => '021'],
            ['name' => 'TUI BLUE Alaya', 'pms_code' => '031'],
            ['name' => 'Jaz Maraya', 'pms_code' => '030'],
            ['name' => 'Lamaya and Samaya Jaz', 'pms_code' => '019'],
            ['name' => 'Reef Masra Solymar', 'pms_code' => 'SRM'],
            ['name' => 'Grand Marsa Jaz', 'pms_code' => 'RGRMA'],
            ['name' => 'Iberotel Costa Mares', 'pms_code' => '33'],
            ['name' => 'Amara Jaz', 'pms_code' => '36'],
            ['name' => 'Luxor Iberotel', 'pms_code' => '016'],
            ['name' => 'Jaz Soma Beach', 'pms_code' => '32'],
            ['name' => 'Steigenberger Ras Soma', 'pms_code' => '522'],
            ['name' => 'Almaza Bay', 'pms_code' => '017'],
            ['name' => 'Jaz Pyramids', 'pms_code' => 'H37'],
            ['name' => 'Little Venice Jaz', 'pms_code' => '053'],
            ['name' => 'Giza Palace', 'pms_code' => 'GPC'],
            ['name' => 'Rivira', 'pms_code' => 'H38'],
            ['name' => 'Jaz Elite Asteria', 'pms_code' => 'H39'],
            ['name' => 'Aurora', 'pms_code' => 'ZAR'],
        ];

        foreach ($hotels as $hotelData) {
            Hotel::updateOrCreate(
                ['pms_code' => $hotelData['pms_code']],
                ['name' => $hotelData['name'], 'status' => 'active']
            );
        }
    }
}
