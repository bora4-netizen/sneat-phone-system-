<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ExpenseCategory;

class ExpenseCategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $expenseCategories = [
            'Purchase Product / ទិញផលិតផល',
            'Steff Salary / ប្រាក់ខែបុគ្គលិក',
            'Electricity - EDC / អគ្គិសនី',
            'Phnom Penh Water Supply - PPWSA / រដ្ឋាករទឹកភ្នំពេញ',
        ];
        foreach ($expenseCategories as $name) {
          ExpenseCategory::create([
                'name' => $name,
            ]);
        }
    }
}
