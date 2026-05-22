<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Storage;

class StorageTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $storages = [
            '16GB',
            '32GB',
            '64GB',
            '128GB',
            '512GB',
            '1TB'
        ];
        foreach ($storages as $storageName) {
            Storage::create([
                'name' => $storageName,
            ]);
        }
    }
}
