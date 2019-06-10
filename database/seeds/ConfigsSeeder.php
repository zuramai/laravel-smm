<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ConfigTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('configs')->delete();
        DB::table('configs')->insert([
            [
                'name' => 'WEB_LOGO_URL',
                'value' => asset('img/logo/laravelsmmv2.png')
            ],
            [
                'name' => 'WEB_LOGO_URL_DARK',
                'value' => asset('img/logo/laravelsmmv2-dark.png')
            ],
            [
                'name' => 'APP_NAME',
                'value' => 'Laravel-SMMV2'
            ],
            [
                'name' => 'WEB_TITLE',
                'value' => 'Laravel-SMMV2'
            ],
            [
                'name' => 'WEB_DESCRIPTION',
                'value' => 'SMM Panel Termurah dan berkualitas tinggi yang menjual jasa layanan Instagram followers,like,view sampai Layanan Youtube seperti subscriber, views, likes. Bergabunglah bersama kami dan tingkatkan penghasilan anda'
            ],
            [
                'name' => 'ADD_MEMBER_PRICE',
                'value' => 5000
            ],
            [
                'name' => 'ADD_AGEN_PRICE',
                'value' => 10000
            ],
            [
                'name' => 'ADD_RESELLER_PRICE',
                'value' => 50000
            ],
            [
                'name' => 'ADD_ADMIN_PRICE',
                'value' => 50000
            ],
            [
                'name' => 'MEMBER_BALANCE',
                'value' => 5000
            ],
            [
                'name' => 'AGEN_BALANCE',
                'value' => 10000
            ],
            [
                'name' => 'RESELLER_BALANCE',
                'value' => 50000
            ],
            [
                'name' => 'ADMIN_BALANCE',
                'value' => 50000
            ],
            [
                'name' => 'MIN_VOUCHER',
                'value' => 5000
            ],
            [
                'name' => 'MAX_VOUCHER',
                'value' => 1000000
            ],
            [
                'name' => 'MIN_DEPOSIT',
                'value' => 5000
            ],
            [
                'name' => 'WEB_FAVICON_URL',
                'value' => asset('img/logo/fav.png')
            ],
            [
                'name' => 'WEB_AUTH_DESCRIPTION',
                'value' => "<h5 class='font-14 text-muted mb-4'>AHMAD-SMM, Website Penyedia Jasa Sosial Media &amp; Pulsa PPOB Terbaik</h5>                <p class='text-muted mb-4'>Dengan bergabung bersama kami, Anda dapat menjadi penyedia jasa social media atau reseller social media seperti jasa penambah Followers, Likes, dll.                Saat ini tersedia berbagai layanan untuk social media terpopuler seperti Instagram, Facebook, Twitter, Youtube, dll. Dan kamipun juga menyediakan Panel Pulsa &amp; PPOB seperti Pulsa All Operator, Paket Data, Saldo Gojek/Grab, All Voucher Game Online, Dll.</p>                <h5 class='font-14 text-muted mb-4'>Kelebihan {{config('web_config')['APP_NAME']}} :</h5>                <div>                    <p><i class='mdi mdi-arrow-right text-primary mr-2'></i>Harga Instagram Followers mulai dari Rp 100 per 1000</p>                    <p><i class='mdi mdi-arrow-right text-primary mr-2'></i>Harga Instagram Likes mulai dari Rp 0.</p>                    <p><i class='mdi mdi-arrow-right text-primary mr-2'></i>Harga Youtube Subscriber mulai dari Rp 10.000 per 1k subscriber</p>                </div>"
            ],

        ]);
    }
}
