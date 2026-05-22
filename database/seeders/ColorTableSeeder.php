<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Color;

class ColorTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $colors = [
            'Silver',
            'Space Gray',
            'Gold',
            'Rose Gold',
            'Midnight Green',
            'Green',
            'Black',
            'Blue',
            'Red',
            'White',
            'Yellow',
            'Orange',
            'Violet',
        ];
        foreach ($colors as $colorName) {
            Color::create([
                'name' => $colorName,
            ]);
        }
    }
}
