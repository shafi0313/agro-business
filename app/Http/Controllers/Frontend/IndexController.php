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
        $data['productCats'] = ProductCat::with(['products.productPack', 'products' => fn ($q) => $q->select('id', 'cat_id', 'name', 'generic', 'image')->whereType(1)])->select(['id', 'name'])->get();
        $data['products']    = Product::where('type', 1)->count();
        $data['users']       = User::whereRole(2)->count();

        SEOTools::setTitle('Home');

        return view('frontend.index', $data);
    }

    public function productsByCat($id)
    {
        $products = Product::where('cat_id', $id)->get();
        return view('frontend.products_by_cat', compact('products'));
    }

    public function allProducts()
    {
        $allProducts = Product::where('type', 1)->get();
        return view('frontend.all_products', compact('allProducts'));
    }

    public function productDetails($id)
    {
        $product = Product::find($id);
        $prices = ProductPackSize::where('product_id', $id)->where('type', 1)->get();
        return view('frontend.product_details', compact('product', 'prices'));
    }

    public function about()
    {
        $about = About::where('id', 1)->first();
        return view('frontend.about', compact('about'));
    }

    public function contact()
    {
        // $about = About::where('id',1)->first();
        return view('frontend.contact');
    }
}
