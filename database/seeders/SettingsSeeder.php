<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
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
        Setting(['app_name'=> env('APP_NAME', 'Mondol Traders')])->save();
        Setting(['app_url'=> env('APP_URL', 'https://mondolag.com')])->save();
        Setting(['app_description'=> ''])->save();
        Setting(['app_keyword'=> ''])->save();
        Setting(['credit_footer'=> '<strong> Copyright &copy; '.date('Y').' <a href="'.env('APP_URL').'"> '.env('APP_NAME', 'My Company').' </a>.</strong> All rights reserved.'])->save();

        Setting(['inv_header_addr'=> 'Alamdanga, Chuadanga.'])->save();
        Setting(['inv_footer'=> '<p>Head office: High Road, Alamdanga, Chuadanga. <i class="fas fa-tty"></i> 07622-56385, <i class="fas fa-mobile-alt"></i>+8801318-302500, Dhaka Office: House # 14, Road # 3, <br> Block # E, Extended Rupnagar (R/A) Sector # 12, Mirpur, Dhaka-1216. <i class="far fa-envelope"></i> r.tuhin@icloud.com, <i class="fas fa-globe-asia"></i> www.mondolag.com</p>.'])->save();

        // AppContact
        // Setting(['app_phone'=> '+8801711-000000'])->save();
        // Setting(['app_email'=> 'support@demo.sss.edu.bd'])->save();
        // Setting(['country'=> 'Bangladesh'])->save();
        // Setting(['division'=> 'Dhaka'])->save();
        // Setting(['sub_division'=> 'Dhaka'])->save();
        // Setting(['city'=> 'Dhaka'])->save();
        // Setting(['postal_code'=> '1200'])->save();
        // Setting(['street'=> 'Lorem Ipsum 1234'])->save();
        // Setting(['contact_description'=> ''])->save();
        // Setting(['facebook'=> env('FACEBOOK_URL', 'tarikmanoar')])->save();
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