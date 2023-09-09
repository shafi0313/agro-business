<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SeontageSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Application Variables
        // AppInfo
        Setting(['company_name'=> 'SEONTAGE'])->save();
        Setting(['app_name'=> 'SEONTAGE'])->save();
        Setting(['app_name_b'=> ''])->save();
        Setting(['app_favicon'=> 'uploads/images/icon/seontage_favicon.png'])->save();
        Setting(['app_logo'=> 'uploads/images/icon/seontage_logo.jpg'])->save();
        Setting(['app_logo_png'=> 'uploads/images/icon/seontage_logo_png.png'])->save();
        Setting(['app_url'=> 'https://seontage.com'])->save();
        Setting(['app_description'=> ''])->save();
        Setting(['app_keyword'=> ''])->save();
        Setting(['is_company'=> 1])->save();
        Setting(['front_footer'=> ''])->save();

        Setting(['inv_header_address'=> 'Uttara, Dhaka.'])->save();
        Setting(['inv_footer'=> '<p>Office: Uttara, Dhaka. <i class="fas fa-mobile-alt"> +8801771 341888. <i class="far fa-envelope"></i> contact@seontage.com, <i class="fas fa-globe-asia"></i> www.seontage.com</p>.'])->save();

        Setting(['front_address'=> 'Office: Ansong-City, Kyonggib-Korea.'])->save();
        Setting(['phone_1'=> ''])->save();
        Setting(['phone_2'=> ''])->save();
        Setting(['email_1'=> 'contact@seontage.com'])->save();
        Setting(['email_2'=> ''])->save();
        Setting(['map'=> ''])->save();

        Setting(['inv_stock_check'=> 1])->save();
        Setting(['inv_officer_id'=> 1])->save();
        Setting(['inv_sms_service'=> 1])->save();
        Setting(['dashboard_report'=> 1])->save();
        Setting(['product_purchase'=> 1])->save();


        // Setting(['facebook'=> 'https://www.facebook.com/adnanagrovet'])->save();
        
    }
}
