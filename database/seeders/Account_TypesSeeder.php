<?php

namespace Database\Seeders;

use App\Models\Account_type;
use Illuminate\Database\Seeder;

class Account_TypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'رأس المال',
            ' حساب مورد',
            ' حساب عميل',
            ' مندوب',
            ' موظف',
            ' بنكي',
            ' مصروفات',
            'قسم داخلي',
            ' عام',
        ];
        foreach ($permissions as $permission) {
            Account_type::create([
                'name' => $permission,
                'active' => 1,
                'related_internal_account' => 1]);

        }

    }
}
