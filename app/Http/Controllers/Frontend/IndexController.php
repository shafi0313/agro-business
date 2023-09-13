<?php

namespace App\Http\Controllers\Frontend;

use App\Models\User;
use App\Models\About;
use App\Models\Slider;
use App\Models\Product;
use App\Models\ProductCat;
use Illuminate\Http\Request;
use App\Models\ProductPackSize;
use App\Http\Controllers\Controller;
use Artesaos\SEOTools\Facades\SEOTools;

class IndexController extends Controller
{
    public function index()
    {
        $data['about']       = About::where('id', 1)->first();
        $data['sliders']     = Slider::all();
        $data['productCats'] = ProductCat::with([
            'products.productPack',
            'products' => fn ($q) =>
            $q->select('id', 'cat_id', 'name', 'generic', 'image')
            ->whereType(1)
        ])
            ->select(['id', 'name'])
            ->get();
        $data['products']    = Product::where('type', 1)->count();
        $data['users']       = User::whereRole(2)->count();
        SEOTools::setTitle(env('HOME_PAGE_TITLE'));

        return view('frontend.index', $data);
    }

    public function productsByCat($id)
    {
        $products = Product::where('cat_id', $id)->get();
        SEOTools::setTitle('Product');
        return view('frontend.products_by_cat', compact('products'));
    }

    public function allProducts()
    {
        $allProducts = Product::where('type', 1)->get();
        SEOTools::setTitle('All Product');
        return view('frontend.all_products', compact('allProducts'));
    }

    public function productDetails($id)
    {
        $product = Product::find($id);
        $prices  = ProductPackSize::where('product_id', $id)->where('type', 1)->get();
        SEOTools::setTitle($product->name);
        return view('frontend.product_details', compact('product', 'prices'));
    }

    public function about()
    {
        $about = About::where('id', 1)->first();
        SEOTools::setTitle('About ' . env('APP_NAME') . ' - Our Agriculture Story and Mission');
        return view('frontend.about', compact('about'));
    }

    public function contact()
    {
        // $about = About::where('id',1)->first();
        SEOTools::setTitle('Contact ' . env('APP_NAME') . ' - Get in Touch with Us');
        return view('frontend.contact');
    }
}
