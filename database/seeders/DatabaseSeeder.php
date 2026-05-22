<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
      $this->call(PermissionTableSeeder::class);
      $this->call(CreateAdminUserSeeder::class);
      $this->call(BrandTableSeeder::class);
      $this->call(ColorTableSeeder::class);
      $this->call(CustomerTableSeeder::class);
      $this->call(ModelTypeTableSeeder::class);
      $this->call(NetworkTableSeeder::class);
      $this->call(StorageTableSeeder::class);
      $this->call(SeriesTableSeeder::class);
      $this->call(CompanySettingTableSeeder::class);
      $this->call(ExpenseCategoryTableSeeder::class);

        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
