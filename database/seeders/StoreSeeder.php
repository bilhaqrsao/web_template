<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class StoreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $stores = [
            [
                'name' => 'Toko A',
                'slug' => 'toko-a',
                'banner' => 'banner.jpg', // add this line
                'description' => 'Toko A adalah toko yang menjual berbagai macam barang kebutuhan sehari-hari.', // add this line
                'address' => 'Jl. Raya No. 1',
                'city' => 'Jakarta', // add this line
                'email' => 'toko-a@email.com', // add this line
                'logo' => 'logo.jpg', // add this line
                'phone' => '08123456789',
                'status' => 1,
                'google_id' => '123456789',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Toko B',
                'slug' => 'toko-b',
                'banner' => 'banner.jpg', // add this line
                'description' => 'Toko B adalah toko yang menjual berbagai macam barang kebutuhan sehari-hari.', // add this line
                'address' => 'Jl. Raya No. 2',
                'city' => 'Jakarta', // add this line
                'email' => 'toko-b@email.com', // add this line
                'logo' => 'logo.jpg', // add this line
                'phone' => '08123456789',
                'status' => 1,
                'google_id' => '123456789',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Toko C',
                'slug' => 'toko-c',
                'banner' => 'banner.jpg', // add this line
                'description' => 'Toko C adalah toko yang menjual berbagai macam barang kebutuhan sehari-hari.', // add this line
                'address' => 'Jl. Raya No. 3',
                'city' => 'Jakarta', // add this line
                'email' => 'toko-c@email.com',
                'logo' => 'logo.jpg', // add this line
                'phone' => '08123456789',
                'status' => 1,
                'google_id' => '123456789',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        // insert data to database
        DB::table('stores')->insert($stores);
    }
}
