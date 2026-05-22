<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\CompanySetting;

class CompanySettingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
      CompanySetting::create([
        'name' => 'CMy Phone Shop',
        'detail' => 'មានលក់ទូរស័ព្ទ',
        'logo' => '',
        'interest' => '3',
        'phone' => '011 699 952',
        'address' => '#44 PSE Cambodia',
        'default_invoice_note' => 'សូមពិនិត្យទំនិញអោយបានត្រឹមត្រូវមុននឹង​ ចាកចេញទំនិញទិញហើយមិនអាចប្តូរវិញបានទេ'
    ]);
    }
}
