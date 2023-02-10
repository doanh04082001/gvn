<?php

namespace Database\Seeders;

use App\Models\Team;
use Illuminate\Database\Seeder;

class TeamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $stores = [
            [
                'name' => "Mobile"
            ],
            [
                'name' => "Website"
            ],
            [
                'name' => "Marketing"
            ]
        ];

        foreach ($stores as $store) {
            Team::create($store);
        }
    }
}
