<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Seeder;

class NotificationSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Customer::whereNull('setting->notification_state')
            ->update([
                'setting->notification_state' => Customer::NOTIFICATION_STATUS_ACTIVE,
            ]);
    }
}
