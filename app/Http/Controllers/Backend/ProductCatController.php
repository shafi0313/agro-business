<?php

namespace App\Http\Controllers\Backend;

use App\Models\ProductCat;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use RealRashid\SweetAlert\Facades\Alert;

class ProductCatController extends Controller
{
    public function index()
    {
        if ($error = $this->authorize('product-category-manage')) {
            return $error;
        }
        $productCats = ProductCat::all();
        return view('admin.product_cat.index', compact('productCats'));
    }

    public function store(Request $request)
    {
        if ($error = $this->authorize('product-category-add')) {
            return $error;
        }
        $data = $this->validate($request, [
            'name' => 'required',
        ]);

        try {
            ProductCat::create($data);
            toast('Size Successfully Inserted', 'success');
            return redirect()->route('product-category.index');
        } catch (\Exception $ex) {
            toast($ex->getMessage().'Size Inserted Failed', 'error');
            return redirect()->back();
        }
    }

    public function edit($id)
    {
        if ($error = $this->authorize('product-category-edit')) {
            return $error;
        }
        $productCat = ProductCat::find($id);
        return view('admin.product_cat.edit', compact('productCat'));
    }

    public function update(Request $request, $id)
    {
        if ($error = $this->authorize('product-category-edit')) {
            return $error;
        }
        $data = $this->validate($request, [
            'name' => 'required',
        ]);

        try {
            ProductCat::find($id)->update($data);
            toast('Category Successfully Update', 'success');
            return redirect()->route('product-category.index');
        } catch (\Exception $ex) {
            toast('Category Update Failed', 'error');
            return redirect()->back();
        }
    }

    public function destroy($id)
    {
        if ($error = $this->authorize('product-category-delete')) {
            return $error;
        }
        try{
            ProductCat::find($id)->delete();
            Alert::success(__('app.success'),__('app.delete-success-message'));
            return redirect()->back();
        }catch (\Exception $ex) {
            Alert::error(__('app.oops'),__('app.delete-error-message'));
            return back();
        }
    }
}
