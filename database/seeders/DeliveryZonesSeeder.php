<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DeliveryZonesSeeder extends Seeder
{
    public function run(): void
    {
        $zones = [
            ['name' => 'Portadown', 'base_fee' => 3.00,  'miles_limit' => 25, 'extra_per_mile' => 2.00, 'active' => true],
            // No HTML estava "Lugan" — mantive igual ao que você escreveu.
            ['name' => 'Lugan',     'base_fee' => 5.00,  'miles_limit' => 25, 'extra_per_mile' => 2.00, 'active' => true],
            ['name' => 'Craigavon', 'base_fee' => 4.00,  'miles_limit' => 25, 'extra_per_mile' => 2.00, 'active' => true],
            ['name' => 'Dungannon', 'base_fee' => 30.00, 'miles_limit' => 25, 'extra_per_mile' => 2.00, 'active' => true],
            ['name' => 'Belfast',   'base_fee' => 30.00, 'miles_limit' => 25, 'extra_per_mile' => 2.00, 'active' => true],
            // "Other locations" pode ter taxa base 0 (calculada manualmente)
            ['name' => 'Other',     'base_fee' => 0.00,  'miles_limit' => 25, 'extra_per_mile' => 2.00, 'active' => true],
        ];

        DB::table('delivery_zones')->upsert(
            $zones,
            ['name'],
            ['base_fee', 'miles_limit', 'extra_per_mile', 'active']
        );
    }
}
