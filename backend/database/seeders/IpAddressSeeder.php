<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class IpAddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        $labels = ['gifts.ad-group.com.au', 'Spare', 'BFBC2 Server'];

        foreach (range(1, 25) as $index) {
            DB::table('ip_addresses')->insert([
                'ip_address' => $faker->ipv4,
                'label' => $faker->randomElement($labels),
                'comment' => $faker->sentence,
                'user_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
