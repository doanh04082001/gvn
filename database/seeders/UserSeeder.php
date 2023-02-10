<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => __('app.super_admin'),
            'email' => env('SUPER_ADMIN_ID', 'superadmin@shilin.vn'),
            'password' => bcrypt(env('SUPER_ADMIN_PASSWORD', '12345678')),
            'email_verified_at' => now(),
            'social_type' => 'gitlab'
        ]);
    }
}
