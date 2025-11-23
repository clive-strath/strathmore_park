<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ParkingLot;

class ParkingLotSeeder extends Seeder
{
    public function run(): void
    {
        $lots = [
            ['name' => 'A', 'total_spots' => 50, 'available_spots' => 50, 'is_active' => true],
            ['name' => 'B', 'total_spots' => 40, 'available_spots' => 40, 'is_active' => true],
            ['name' => 'C', 'total_spots' => 30, 'available_spots' => 30, 'is_active' => true],
        ];

        foreach ($lots as $lot) {
            ParkingLot::create($lot);
        }
    }
}
