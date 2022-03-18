<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\ProductCat;
use Illuminate\Http\Request;

class ProductCatController extends Controller
{
    public function index()
    {
        $productCats = ProductCat::all();
        return view('admin.product_cat.index', compact('productCats'));
    }

    public function store(Request $request)
    {
        if ($error = $this->sendPermissionError('create')) {
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
        if ($error = $this->sendPermissionError('edit')) {
            return $error;
        }
        $productCat = ProductCat::find($id);
        return view('admin.product_cat.edit', compact('productCat'));
    }

    public function update(Request $request, $id)
    {
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
        if ($error = $this->sendPermissionError('delete')) {
            return $error;
        }
        ProductCat::find($id)->delete();
        toast('Successfully Deleted', 'success');
        return redirect()->back();
    }
}
