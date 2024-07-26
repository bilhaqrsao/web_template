<?php

namespace Database\Seeders;

use App\Models\Utility\IdentityWeb;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class Identity extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        IdentityWeb::create([
            'name_website' => 'Your Website',
            'heads_name' => 'Your Name',
            'moto' => 'Your Moto',
            'description' => 'Your Description',
            'email' => 'email@email.com',
            'address' => 'Your Address',
            'phone' => '08123456789',
            'whatsapp' => '08123456789',
            'facebook' => 'https://facebook.com',
            'instagram' => 'https://instagram.com',
            'twitter' => 'https://twitter.com',
            'youtube' => 'https://youtube.com',
            'map' => '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3983.4565370219525!2d104.66211787589174!3d-3.235997896739073!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e3b95fbe296a751%3A0x187aae1a6009cd1f!2sKESBANGPOL%20KAB.%20OGAN%20ILIR!5e0!3m2!1sen!2sid!4v1721748717106!5m2!1sen!2sid" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>',
            'favicon' => 'favicon.webp',
            'logo' => 'logo.webp',
            'heads_photo' => 'heads.webp',
        ]);
    }
}
