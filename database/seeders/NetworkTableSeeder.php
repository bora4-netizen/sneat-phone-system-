<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Network;

class NetworkTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $models = [
            'AT & T Mobility',
            'T-Mobile',
            'Vodafone',
            'Bell Mobility',
        ];
        foreach ($models as $modelName) {
          Network::create([
                'name' => $modelName,
            ]);
        }
    }
}
