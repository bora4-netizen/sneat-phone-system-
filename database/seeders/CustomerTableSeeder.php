<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Customer;

class CustomerTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
      Customer::create([
        'name' => 'Walk in Customer',
        'phone' => '000000000',
        'customer_type' => 1,
        'employee_id' => 1
    ]);
    }
}
