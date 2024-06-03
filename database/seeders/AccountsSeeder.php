<?php

namespace Database\Seeders;

use App\Models\Account;
use Illuminate\Database\Seeder;

class AccountsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'الحبيشي ',
            'الحاشدي',
            'الباشا',
            'هائل سعيد',
            'حسن الفقيه',
            'النجاشي',
            'العملاء الأب',
            'الموردين الأب',
            'المصروفات الأب',
        ];
        foreach ($permissions as $permission) {
            Account::create([
                'name' => $permission,
                'is_parent' => 1,
                'account_types_id' => 1,
                'account_number' => 1,
                'start_balance_status' => 3,
                'start_balance' => 0,
                'current_balance' => 0,
                'added_by' => auth()->user()->id,
                'com_code' => auth()->user()->com_code,
                'is_archived' => 1,
                'date' => date('Y-m-d H:i:s'),

            ]);

        }
    }
}
