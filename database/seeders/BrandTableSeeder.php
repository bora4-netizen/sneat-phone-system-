<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Brand;

class BrandTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $brands = [
            'APPLE' => 'apple.png',
            'SAMSUNG'=> 'samsung.png',
            'HUAWEI'=> 'huawei.png',
            'VIVO'=> 'vivo.png',
            'OPPO'=> 'oppo.png',
            'XIAOMI'=> 'xiaomi.png',
            'REALME'=> 'realme.png',
            'OnePlus'=> 'one-plus.png',
            'NOKIA'=> 'nokia.png',
            'ASUS'=> 'asus.png',
            'SONY'=> 'sony.png',
            'TECNO'=> 'tecno.png',


        ];
        foreach ($brands as $key => $brand) {
            Brand::create([
                'name' => $key,
                'logo' => $brand,
            ]);
        }
    }
}
