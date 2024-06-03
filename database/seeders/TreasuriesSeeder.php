<?php

namespace Database\Seeders;

use App\Models\Treasuries;
use Illuminate\Database\Seeder;

class TreasuriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Treasuries::create([
            'name' => ' الخزنة الرئيسية',
            'last_isal_exchange' => 0,
            'last_isal_collect' => 500,
            'added_by' => 'المدير العام',
            'com_code' => 1,
            'date' => now(),
            'updated_by' => 'لم تعدل',

        ]);
    }
}
