<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AdnanSettingsSeeder extends Seeder
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
        Setting(['company_name'=> 'New Adnan Agrovet Ltd.'])->save();
        Setting(['app_name'=> 'New Adnan Agrovet Ltd.'])->save();
        Setting(['app_name_b'=> 'নিউ আদনান এগ্রোভেট লিমিটেড।'])->save();
        Setting(['app_favicon'=> 'uploads/images/icon/adnan_favicon.png'])->save();
        Setting(['app_logo'=> 'uploads/images/icon/adnan_logo.jpg'])->save();
        Setting(['app_logo_png'=> 'uploads/images/icon/adnan_logo_png.png'])->save();
        Setting(['app_url'=> 'https://newadnanagrovet.com'])->save();
        Setting(['app_description'=> ''])->save();
        Setting(['app_keyword'=> 'adnan, Agro, adnan Agro, New Adnan Agrovet Ltd'])->save();
        // Setting(['credit_footer'=> ''])->save();

        Setting(['inv_header_address'=> 'Uttara, Dhaka.'])->save();
        Setting(['inv_footer'=> '<p>Office: Uttara, Dhaka. <i class="fas fa-mobile-alt"> +8801771 341888. <i class="far fa-envelope"></i> contact@newadnanagrovet.com, <i class="fas fa-globe-asia"></i> www.newadnanagrovet.com</p>.'])->save();

        Setting(['front_address'=> 'Office: Uttara, Dhaka-1216.'])->save();
        Setting(['phone_1'=> '+8801771 341888'])->save();
        Setting(['phone_2'=> ''])->save();
        Setting(['email_1'=> 'contact@newadnanagrovet.com'])->save();
        Setting(['email_2'=> ''])->save();
        Setting(['map'=> 'https://www.google.com/maps/place/Alamdanga+Upazila/@23.7636748,88.9389079,14.5z/data=!4m5!3m4!1s0x39fec84f2e2dc219:0x3d5527c829fc16e!8m2!3d23.7625846!4d88.9438166'])->save();

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