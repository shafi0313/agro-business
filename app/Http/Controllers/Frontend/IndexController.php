<?php

namespace App\Http\Controllers\Frontend;

use App\Models\User;
use App\Models\About;
use App\Models\Slider;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\ProductPackSize;
use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    public function index()
    {
        $about = About::where('id',1)->first();
        $sliders = Slider::all();
        $products = Product::where('type', 1)->get();
        $users = User::whereRole(2)->count();
        return view('frontend.index', compact('sliders','products','about','users'));
    }

    public function productsByCat($id)
    {
        $allProducts = Product::where('cat_id', $id)->get();
        return view('frontend.products_by_cat', compact('allProducts'));
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
        return view('frontend.product_details', compact('product','prices'));
    }

    public function about()
    {
        $about = About::where('id',1)->first();
        return view('frontend.about', compact('about'));
    }

    public function contact()
    {
        // $about = About::where('id',1)->first();
        return view('frontend.contact');
    }

}
