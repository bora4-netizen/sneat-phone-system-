<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ModelType;

class ModelTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $models = [
            'LLA',
            'ZA',
        ];
        foreach ($models as $modelName) {
            ModelType::create([
                'name' => $modelName,
            ]);
        }
    }
}
