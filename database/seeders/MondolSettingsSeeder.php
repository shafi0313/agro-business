<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class MondolSettingsSeeder extends Seeder
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
        Setting(['company_name'=> 'Mondol Traders'])->save();
        Setting(['app_name'=> 'Mondol Traders'])->save();
        Setting(['app_name_b'=> 'মন্ডল ট্রেডার্স'])->save();
        Setting(['app_favicon'=> 'uploads/images/icon/mondol_favicon.png'])->save();
        Setting(['app_logo'=> 'uploads/images/icon/mondol_logo.jpg'])->save();
        Setting(['app_logo_png'=> 'uploads/images/icon/mondol_logo_png.png'])->save();
        Setting(['app_url'=> 'https://mondolag.com'])->save();
        Setting(['app_description'=> ''])->save();
        Setting(['app_keyword'=> 'Mondol, Agro, Mondol Agro, Mondol Traders, Alamdanga, mondolag'])->save();
        Setting(['is_company'=> 1])->save();
        Setting(['front_footer'=> 'ফসলের মাঠে কৃষকের বিশ্বস্ত সহযোগী'])->save();

        Setting(['inv_header_address'=> 'Alamdanga, Chuadanga.'])->save();
        Setting(['inv_footer'=> '<p>Head office: High Road, Alamdanga, Chuadanga. <i class="fas fa-tty"></i> 07622-56385, <i class="fas fa-mobile-alt"></i>+8801318-302500, Dhaka Office: House # 14, Road # 3, <br> Block # E, Extended Rupnagar (R/A) Sector # 12, Mirpur, Dhaka-1216. <i class="far fa-envelope"></i> r.tuhin@icloud.com, <i class="fas fa-globe-asia"></i> www.mondolag.com</p>.'])->save();

        Setting(['front_address'=> 'Head office: High Road, Alamdanga, Chuadanga. <br>Dhaka Office: House # 14, Road # 3, Block # E, Extended Rupnagar (R/A) Sector # 12, Mirpur, Dhaka-1216.'])->save();
        Setting(['phone_1'=> '+8801318-302500'])->save();
        Setting(['phone_2'=> '02477790385'])->save();
        Setting(['email_1'=> 'r.tuhin@icloud.com'])->save();
        Setting(['email_2'=> 'info@mondolag.com'])->save();
        Setting(['map'=> 'https://www.google.com/maps/place/Alamdanga+Upazila/@23.7636748,88.9389079,14.5z/data=!4m5!3m4!1s0x39fec84f2e2dc219:0x3d5527c829fc16e!8m2!3d23.7625846!4d88.9438166'])->save();

        Setting(['inv_stock_check'=> 1])->save();
        Setting(['inv_officer_id'=> 1])->save();
        Setting(['inv_sms_service'=> 1])->save();
        Setting(['dashboard_report'=> 0])->save();
        Setting(['product_purchase'=> 0])->save();


        // Setting(['facebook'=> 'https://www.facebook.com/adnanagrovet'])->save();
        // Setting(['twitter'=> env('TWITTER_URL', 'tarikmanoar')])->save();
        // Setting(['youtube'=> env('YOUTUBE_URL', 'tarikmanoar')])->save();
        // Setting(['instagram'=> env('INSTAGRAM_URL', 'tarikmanoar')])->save();
        // Setting(['linkedin'=> env('LINKEDIN_URL', 'tarikmanoar')])->save();
        // Setting(['telegram'=> env('TELEGRAM_URL', 'tarikmanoar')])->save();
        // Setting(['whatsapp'=> env('WHATSAPP', 'tarikmanoar')])->save();

        //! App Config
        // Setting(['google_analytics_id' => 'UA-123456789-1'])->save();
        // Setting(['publisher_id' => 'ca-pub-12345678912345678'])->save();
        // Setting(['disqus_short_name' => 'sssedubd_'])->save();
        // Setting(['analytics_view_id' => '123456789'])->save();
        // Setting(['credential_file' => 'credential.json'])->save();
        // Setting(['google_map_code' => 'https://www.google.com/maps/embed/v1/place?q=place_id:ChIJZW3qh40Q_zkRz2Ey-U4DfWI&key=AIzaSyBFw0Qbyq9zTFTd-tUY6dZWTgaQzuU17R8'])->save();
    }
}
