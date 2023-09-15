<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SeontaegSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Setting(['company_name'=> 'SEONTAEG'])->save();
        Setting(['app_name'=> 'SEONTAEG'])->save();
        Setting(['app_name_b'=> ''])->save();
        Setting(['app_favicon'=> 'uploads/images/icon/seontage_favicon.png'])->save();
        Setting(['app_logo'=> 'uploads/images/icon/seontage_logo.jpg'])->save();
        Setting(['app_logo_png'=> 'uploads/images/icon/seontage_logo_png.png'])->save();
        Setting(['app_url'=> 'https://seontage.com'])->save();
        Setting(['app_description'=> ''])->save();
        Setting(['app_keyword'=> ''])->save();
        Setting(['is_company'=> 1])->save();
        Setting(['front_footer'=> 'SEONTAEG is a trusted manufacturer and distributor of veterinary medicines for cattle, swine, poultry, sheep, fish, and companion animals. Learn about our GMP-compliant production facility established in Seoul, Korea in July 1998. Discover our range of high-quality injectable preparations, premixes, water-soluble powders, and oral liquids. With a commitment to research and development, SEONTAEG exports its top-tier products to 10 countries. Explore our comprehensive line of veterinary pharmaceuticals, including injectables, oral liquids, powders, tablets, boluses, and local treatment solutions. Contact us for inquiries or product information.'])->save();
        Setting(['index_title'=> 'SEONTAEG - Manufacturer and Distributor of Veterinary Medicines'])->save();

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

        Setting(['enable_developed_by'=> 0])->save();
        Setting(['enable_client_count'=> 1])->save();
        Setting(['enable_product_count'=> 1])->save();
        Setting(['enable_district_count'=> 0])->save();
        Setting(['enable_multi_lang'=> 0])->save();
        Setting(['enable_home_about'=> 1])->save();
        // Setting(['facebook'=> 'https://www.facebook.com/adnanagrovet'])->save();
    }
}
