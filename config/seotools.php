<?php

/**
 * @see https://github.com/artesaos/seotools
 */

$name = $description = $keyword = '';
if (request()->getHttpHost() == 'seontaeg.com' || request()->getHttpHost() == 'www.seontaeg.com') {
    $name        = 'SEONTAEG';
    $description = 'SEONTAEG is manufacturer and distributor of veterinary medicines for cattle, swine, poultry, sheep, fish and companion animals. The company SEONTAEG was founded and production facility was established in Seoul, Korea on July 1998. All products are manufactured according to the GMP regulations and the company is equipped with a professional laboratory, staffed by highly qualified personnel to ensure quality control raw materials to finished products. Research and development is important role in the companies strategic growth. SEONTAEG has developed a complete range of veterinary products including high quality injectable preparations, premix, water soluble powders and extensive range of oral liquids. SEONTAEG now exports its high quality products to 10 countries overseas. We offer you a wide range of veterinary pharmaceuticals: injectable, oral liquids, powders, tablets and boluses and liquids and ointments for local treatments. Please feel free to contact us if you have any questions or interest in our products.';
    $keyword     = 'veterinary medicines, SEONTAEG, manufacturer, distributor, GMP, Seoul, Korea, injectable preparations, premixes, water-soluble powders, oral liquids, research and development, cattle medicine, swine medicine, poultry medicine, sheep medicine, fish medicine, companion animals, international export, local treatment solutions, quality control';
}elseif(request()->getHttpHost() == 'mondolag.com' || request()->getHttpHost() == 'www.mondolag.com'){
    $name        = 'Mondol Treaders';
    $description = 'Mondol Treaders is an agriculture company offering a wide range of agricultural products including Insecticides, Fungicides, Herbicides, Yield Boosters, and Fertilizers. We specialize in crop protection and nutrition solutions to help farmers enhance yields and crop health. Explore our quality agricultural products for your farming needs.';
    $keyword     = 'Mondol Treaders, agriculture company, Insecticide, Fungicide, Herbicide, Yield Booster, Fertilizer, agricultural products, crop protection, crop nutrition, farming supplies';
}

return [
    'meta' => [
        /*
         * The default configurations to be used by the meta generator.
         */
        'defaults'       => [
            'title'        => $name, // set false to total remove
            'titleBefore'  => false, // Put defaults.title before page title, like 'It's Over 9000! - Dashboard'
            'description'  => $description, // set false to total remove
            'separator'    => ' - ',
            'keywords'     => [$keyword],
            'canonical'    => 'full', // Set to null or 'full' to use Url::full(), set to 'current' to use Url::current(), set false to total remove
            'robots'       => 'all', // Set to 'all', 'none' or any combination of index/noindex and follow/nofollow
        ],
        /*
         * Webmaster tags are always added.
         */
        'webmaster_tags' => [
            'google'    => null,
            'bing'      => null,
            'alexa'     => null,
            'pinterest' => null,
            'yandex'    => null,
            'norton'    => null,
        ],

        'add_notranslate_class' => false,
    ],
    'opengraph' => [
        /*
         * The default configurations to be used by the opengraph generator.
         */
        'defaults' => [
            'title'       => $name, // set false to total remove
            'description' => $description, // set false to total remove
            'url'         => null, // Set null for using Url::current(), set false to total remove
            'type'        => 'WebPage',
            'site_name'   => $name,
            'images'      => [],
        ],
    ],
    'twitter' => [
        /*
         * The default values to be used by the twitter cards generator.
         */
        'defaults' => [
            //'card'        => 'summary',
            //'site'        => '@LuizVinicius73',
        ],
    ],
    'json-ld' => [
        /*
         * The default configurations to be used by the json-ld generator.
         */
        'defaults' => [
            'title'       => $name, // set false to total remove
            'description' => $description, // set false to total remove
            'url'         => null, // Set to null or 'full' to use Url::full(), set to 'current' to use Url::current(), set false to total remove
            'type'        => 'WebPage',
            'images'      => [],
        ],
    ],
];
