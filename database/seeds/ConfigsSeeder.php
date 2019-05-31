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
                'name' => 'app_name',
                'value' => 'Awesome App'
            ],
            [
                'name' => 'currency_symbol',
                'value' => '$'
            ],
            [
                'name' => 'currency_code',
                'value' => 'USD'
            ],
            [
                'name' => 'logo',
                'value' => 'images/70c1765f63707351bc3b5666dcdc7ce8.png'
            ],
            [
                'name' => 'date_format',
                'value' => 'd-m-Y'
            ],
            [
                'name' => 'banner',
                'value' => 'images/99d575092d9e0fd3a1ad35b091660b3e.png'
            ],
            [
                'name' => 'home_page_description',
                'value' => '⭐️Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum'
            ],
            [
                'name' => 'recaptcha_public_key',
                'value' => 'pub_abc123'
            ],
            [
                'name' => 'recaptcha_private_key',
                'value' => 'prv_abc123'
            ],
            [
                'name' => 'minimum_deposit_amount',
                'value' => '10'
            ],
            [
                'name' => 'home_page_meta',
                'value' => '<meta name="description" content="A description">
<meta name="keywords" content="SMM Services">'
            ],
            [
                'name' => 'module_api_enabled',
                'value' => '1'
            ],
            [
                'name' => 'module_support_enabled',
                'value' => '1'
            ],
            [
                'name' => 'theme_color',
                'value' => '#4285f4'
            ],
            [
                'name' => 'background_color',
                'value' => '#e9ebee'
            ],
            [
                'name' => 'language',
                'value' => 'en'
            ],
            [
                'name' => 'display_price_per',
                'value' => '1000'
            ],
            [
                'name' => 'admin_note',
                'value' => 'Update me I am admin note'
            ],
            [
                'name' => 'admin_layout',
                'value' => 'container-fluid'
            ],
            [
                'name' => 'user_layout',
                'value' => 'container'
            ],
            [
                'name' => 'panel_theme',
                'value' => 'material'
            ],
            [
                'name' => 'anonymizer',
                'value' => 'https://anonym.to/?'
            ],
            [
                'name' => 'front_page',
                'value' => 'login'
            ],
            [
                'name' => 'show_service_list_without_login',
                'value' => 'YES'
            ],
            [
                'name' => 'notify_email',
                'value' => 'notify@example.com'
            ],
            [
                'name' => 'currency_separator',
                'value' => '.'
            ],
            [
                'name' => 'app_key',
                'value' => '$2y$10$Bpvj5bSA7mn9D83x/pjFqOhBfRG2dcnh52SjKhY0JytfMx5.1MSPK'
            ],
            [
                'name' => 'app_code',
                'value' => '$2y$10$JoSs59ZA2LPqRp7Xs9Ed6.57zDdGqLNhr6UAAAy/8WffBxMGTOpz2'
            ],
            [
                'name' => 'envato_username',
                'value' => ''
            ],
            [
                'name' => 'envato_purchase_code',
                'value' => ''
            ],
            [
                'name' => 'module_subscription_enabled',
                'value' => '1'
            ],
            [
                'name' => 'timezone',
                'value' => 'America/Chicago'
            ],

        ]);
    }
}
