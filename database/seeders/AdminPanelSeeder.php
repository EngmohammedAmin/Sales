<?php

namespace Database\Seeders;

use App\Models\Admin_Panel_Setting;
use Illuminate\Database\Seeder;

class AdminPanelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Admin_Panel_Setting::create([
            'system_name' => ' شركة حاضرين ',
            'photo' => 'صورة',
            'general_alert' => 'لا إشعار',
            'address' => 'إب-شارع الثورة-أمام بوابة المرور',
            'phone' => 770914610,
            'added_by' => 'المدير العام',
            'updated_by' => 0,
            'com_code' => 1,
            'customer_parent_account_number' => 0,
            'supplier_parent_account_number' => 0,

        ]);
    }
}
