<?php

namespace App\Http\Controllers\Backend;

use Carbon\Carbon;
use App\Models\Product;
use App\Models\LicenseCat;
use Illuminate\Http\Request;
use App\Models\ProductLicense;
use App\Http\Controllers\Controller;

class ProductLicenseController extends Controller
{
    public function index()
    {
        if ($error = $this->authorize('product-license-manage')) {
            return $error;
        }
        $licenseCats = LicenseCat::all();
        return view('admin.product_license.index', compact('licenseCats'));
    }

    public function create()
    {
        if ($error = $this->authorize('product-license-add')) {
            return $error;
        }
        $products = Product::select(['id','name','type'])->where('type', 1)->get();
        $licenseCats = LicenseCat::select(['id','name'])->get();
        return view('admin.product_license.create', compact('products','licenseCats'));
    }

    public function store(Request $request)
    {
        if ($error = $this->authorize('product-license-add')) {
            return $error;
        }
        $data = $this->validate($request, [
            'license_cat_id' => 'required',
            'product_id' => 'required',
            'reg_no' => 'required',
            'issue_date' => 'required',
            'expired_date' => 'required',
            'renewal_date' => 'required',
        ]);

        try{
            ProductLicense::create($data);
            toast('Data Inserted','success');
            return redirect()->route('product-license.index');
        }catch(\Exception $ex){
            toast('Data Insert Failed','error');
            return redirect()->back();
        }
    }

    public function show($id)
    {
        if ($error = $this->authorize('product-license-show')) {
            return $error;
        }
        $licese = LicenseCat::where('id', $id)->first();
        $products = ProductLicense::where('license_cat_id', $id)->orderBy('renewal_date','DESC')->get();
        return view('admin.product_license.show', compact('products','licese'));
    }

    public function edit($id)
    {
        if ($error = $this->authorize('product-license-edit')) {
            return $error;
        }
        $product = ProductLicense::find($id);
        $licenseCats = LicenseCat::select(['id','name'])->where('id', '!=', $product->id)->get();
        $getProducts = Product::select(['id','name','type'])->where('type', 1)->where('id','!=', $product->id)->get();

        return view('admin.product_license.edit', compact('product','licenseCats','getProducts'));
    }

    public function update(Request $request, $id)
    {
        if ($error = $this->authorize('product-license-edit')) {
            return $error;
        }
        $data = $this->validate($request, [
            'license_cat_id' => 'required',
            'product_id' => 'required',
            'reg_no' => 'required',
            'issue_date' => 'required',
            'expired_date' => 'required',
            'renewal_date' => 'required',
        ]);
        $data = [
            'issue_date' => Carbon::createFromFormat('m/d/Y', $request->issue_date)->format('Y-m-d'),
            'expired_date' => Carbon::createFromFormat('m/d/Y', $request->expired_date)->format('Y-m-d'),
            'renewal_date' => Carbon::createFromFormat('m/d/Y', $request->renewal_date)->format('Y-m-d'),
        ];

        try{
            ProductLicense::find($id)->update($data);
            toast('Data Updated','success');
            return redirect()->route('product-license.index');
        }catch(\Exception $ex){
            toast($ex->getMessage().'Data Update Failed','error');
            return redirect()->back();
        }
    }

}
