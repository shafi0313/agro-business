<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class RESettingsSeeder extends Seeder
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
        Setting(['company_name'=> 'Rajkonna Enterprise'])->save();
        Setting(['app_name'=> 'Rajkonna Enterprise'])->save();
        Setting(['app_name_b'=> 'রাজকন্যা এন্টারপ্রাইস।'])->save();
        Setting(['app_favicon'=> 'uploads/images/icon/re_favicon.png'])->save();
        Setting(['app_logo'=> 'uploads/images/icon/re_logo.jpg'])->save();
        Setting(['app_logo_png'=> 'uploads/images/icon/re_logo_png.png'])->save();
        Setting(['app_url'=> 'https://re.softgiantbd.com'])->save();
        Setting(['app_description'=> ''])->save();
        Setting(['app_keyword'=> 'Rajkonna, Rajkonna Enterprise'])->save();
        Setting(['is_company'=> 0])->save();

        Setting(['inv_header_address'=> 'Uttara, Dhaka.'])->save();
        Setting(['inv_footer'=> '<p>Office: Uttara, Dhaka. <i class="fas fa-mobile-alt"> +880 1716-906578. <i class="far fa-envelope"></i> contact@re.softgiantbd.com, <i class="fas fa-globe-asia"></i> re.softgiantbd.com/</p>.'])->save();

        Setting(['front_address'=> 'Office: Uttara, Dhaka-1216.'])->save();
        Setting(['phone_1'=> '+880 1716-906578'])->save();
        // Setting(['phone_2'=> ''])->save();
        Setting(['email_1'=> 'contact@re.softgiantbd.com'])->save();
        // Setting(['email_2'=> ''])->save();
        // Setting(['map'=> 'https://www.google.com/maps/place/Alamdanga+Upazila/@23.7636748,88.9389079,14.5z/data=!4m5!3m4!1s0x39fec84f2e2dc219:0x3d5527c829fc16e!8m2!3d23.7625846!4d88.9438166'])->save();

        Setting(['inv_stock_check'=> 1])->save();
        Setting(['inv_officer_id'=> 1])->save();
        Setting(['inv_sms_service'=> 0])->save();
        Setting(['dashboard_report'=> 1])->save();
        Setting(['product_purchase'=> 1])->save();


        // Setting(['facebook'=> 'https://www.facebook.com/adnanagrovet'])->save();

        //! App Config
        // Setting(['google_analytics_id' => 'UA-123456789-1'])->save();
        // Setting(['publisher_id' => 'ca-pub-12345678912345678'])->save();
        // Setting(['disqus_short_name' => 'sssedubd_'])->save();
        // Setting(['analytics_view_id' => '123456789'])->save();
        // Setting(['credential_file' => 'credential.json'])->save();
        // Setting(['google_map_code' => 'https://www.google.com/maps/embed/v1/place?q=place_id:ChIJZW3qh40Q_zkRz2Ey-U4DfWI&key=AIzaSyBFw0Qbyq9zTFTd-tUY6dZWTgaQzuU17R8'])->save();
    }
}
