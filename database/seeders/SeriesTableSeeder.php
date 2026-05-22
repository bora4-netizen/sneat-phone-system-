<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Brand;
use App\Models\Series;

class SeriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $series = [
            'iPhone 15',
            'iPhone 15 Plug',
            'iPhone 15 Pro',
            'iPhone 15 Ultra',
        ];
        $brand = Brand::where('name', 'APPLE')->first();
        foreach ($series as $seriesName) {
          Series::create([
                'name' => $seriesName,
                'brand_id' => $brand->id,
            ]);
        }
    }
}
