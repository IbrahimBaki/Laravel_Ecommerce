<?php

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Setting::setMany([
            'default_locale'=>'en',
            'default_timezone'=>'Africa/Cairo',
            'reviews_enabled'=>true,
            'supported_currencies'=>['USD','Le','SAR'],
            'default_currency'=>'USD',
            'store_email'=>'3baa2y@gmail.com',
            'search_engine'=>'mysql',
            'local_shipping_coast'=>0,
            'outer_shipping_coast'=>0,
            'free_shipping_coast'=>0,
            'translatable'=>[
                'store_name'=>'Wolf Store',
                'free_shipping_label'=>'Free Shipping',
                'local_label'=>'Local Shipping',
                'outer_label'=>'Outer Shipping',

            ],
        ]);
    }
}
