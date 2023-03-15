<?php

namespace App\Http\Controllers\Backend;

use App\Models\Product;
use App\Models\PackSize;
use App\Models\ProductCat;
use App\Models\ProductStock;
use Illuminate\Http\Request;
use App\Models\ProductPackSize;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use RealRashid\SweetAlert\Facades\Alert;

class ProductController extends Controller
{
    public function index()
    {
        if ($error = $this->authorize('store-product-manage')) {
            return $error;
        }
        $porducts = Product::where('type', 1)->orderBy('name', 'ASC')->get();
        return view('admin.product.index', compact('porducts'));
    }

    public function create()
    {
        if ($error = $this->authorize('store-product-add')) {
            return $error;
        }
        $productCats = ProductCat::all();
        $packSizes = PackSize::where('type', 1)->get();
        return view('admin.product.create', compact('packSizes', 'productCats'));
    }

    public function store(Request $request)
    {
        if ($error = $this->authorize('store-product-add')) {
            return $error;
        }
        $this->validate($request, [
            'name'        => 'required',
            'generic'     => 'required',
            'indications' => 'required',
            'image'       => 'nullable|image|mimes:png,jpeg,jpg,JPG,PNG,JPEG,svg|max:2048',
        ]);

        DB::beginTransaction();

        $data = [
            'cat_id'      => $request->get('cat_id'),
            'name'        => $request->get('name'),
            'generic'     => $request->get('generic'),
            'indications' => $request->get('indications'),
            'type'        => 1,
        ];
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $image_name = "product_".rand(0, 1000000).'.'.$image->getClientOriginalExtension();
            $request->image->move('uploads/images/product/', $image_name);
        }
        if($request->hasFile('image')){
            $data['image'] = imageStore($request, 'image','product', 'uploads/images/product/');
        }
        $porduct = Product::create($data);
        $porductId = $porduct->id;

        foreach ($request->size as $key => $v) {
            $data=[
                'product_id'  => $porductId,
                'size'        => $request->size[$key],
                'purchase'    => $request->purchase[$key],
                'cash'        => $request->cash[$key],
                'credit'      => $request->credit[$key],
                'trade_price' => $request->trade_price[$key],
                'mrp'         => $request->mrp[$key],
                'type'        => 1,
            ];
            $productPackSize = ProductPackSize::create($data);
            $productPackSizeId = $productPackSize->id;

            // Product Stock
            $productStock = [
                'product_id'           => $porductId,
                'product_pack_size_id' => $productPackSizeId,
                'quantity'             => 0,
                'damage'               => 0,
                'type'                 => 1,                    // Product
            ];
            ProductStock::create($productStock);

            // Label Stock
            $productStock = [
                'product_id'           => $porductId,
                'product_pack_size_id' => $productPackSizeId,
                'quantity'             => 0,
                'damage'               => 0,
                'type'                 => 4,                    // Label
            ];
            ProductStock::create($productStock);
        }

        try {
            DB::commit();
            toast('Product Successfully Inserted', 'success');
            return redirect()->route('product.index');
        } catch (\Exception $ex) {
            DB::rollBack();
            toast($ex->getMessage().'Product Inserted Failed', 'error');
            return back();
        }
    }

    public function addSizePrice(Request $request)
    {
        if ($error = $this->authorize('store-product-add')) {
            return $error;
        }
        $this->validate($request, [
            'size'     => 'required',
            'purchase' => 'required',
            'cash'     => 'required',
            'credit'   => 'required',
            'mrp'      => 'required',
        ]);
        DB::beginTransaction();
        $product_id = $request->get('product_id');
        foreach ($request->size as $key => $v) {
            $data=[
                'product_id'  => $product_id,
                'size'        => $request->size[$key],
                'purchase'    => $request->purchase[$key],
                'cash'        => $request->cash[$key],
                'credit'      => $request->credit[$key],
                'trade_price' => $request->trade_price[$key],
                'mrp'         => $request->mrp[$key],
                'type'        => 1,
            ];
            $productPackSize = ProductPackSize::create($data);

            $productPackSizeId = $productPackSize->id;
            $productStock = [
                'product_id'           => $product_id,
                'product_pack_size_id' => $productPackSizeId,
                'quantity'             => 0,
                'type'                 => 1,                    // Product
            ];
            ProductStock::create($productStock);

            $productStock = [
                'product_id'           => $product_id,
                'product_pack_size_id' => $productPackSizeId,
                'quantity'             => 0,
                'type'                 => 4,                    // Label
            ];
            ProductStock::create($productStock);
        }

        try {
            DB::commit();
            toast('New Size Successfully Inserted', 'success');
            return redirect()->back();
        } catch (\Exception $ex) {
            DB::rollBack();
            toast($ex->getMessage().'New Size Inserted Failed', 'error');
            return redirect()->back();
        }
    }

    public function edit($id)
    {
        if ($error = $this->authorize('store-product-edit')) {
            return $error;
        }
        $packSizess = PackSize::where('type', 1)->get();
        $product = Product::find($id);
        $productCats = ProductCat::where('id', '!=', $product->cat_id)->get();
        $packSizes = ProductPackSize::where('product_id', $id)->get();
        return view('admin.product.edit', compact('product', 'packSizes', 'packSizess', 'productCats'));
    }

    public function update(Request $request, $id)
    {
        if ($error = $this->authorize('store-product-edit')) {
            return $error;
        }

        $data = [
            'name'        => $request->get('name'),
            'cat_id'      => $request->get('cat_id'),
            'generic'     => $request->get('generic'),
            'indications' => $request->get('indications'),
            'type'        => 1,
        ];
        $image = Product::find($id)->image;
        if($request->hasFile('image')){
            $data['image'] = imageUpdate($request, 'image', 'product', 'uploads/images/product/', $image);
        }

        DB::beginTransaction();
        try {
            Product::find($id)->update($data);
            if (count($request->id) > 0) {
                foreach ($request->id as $key => $v) {
                    $packData=[
                        'size'        => $request->size[$key],
                        'purchase'    => $request->purchase[$key],
                        'cash'        => $request->cash[$key],
                        'credit'      => $request->credit[$key],
                        'trade_price' => $request->trade_price[$key],
                        'mrp'         => $request->mrp[$key],
                    ];
                    $pack = ProductPackSize::where('id', $request->id[$key])->first();
                    $pack->update($packData);
                }
            }
            DB::commit();
            toast('Product Successfully Inserted', 'success');
            return redirect()->route('product.index');
        } catch (\Exception $ex) {
            DB::rollBack();
            toast($ex->getMessage().'Product Inserted Failed', 'error');
            return redirect()->back();
        }
    }


    public function deletePackSize($packId)
    {
        if ($error = $this->authorize('store-product-delete')) {
            return $error;
        }
        ProductPackSize::findOrFail($packId)->delete();
        toast('Product Size Successfully Inserted', 'success');
        return redirect()->back();
    }

    public function destroy($id)
    {
        if ($error = $this->authorize('store-product-delete')) {
            return $error;
        }
        $product = Product::find($id);
        $productPackSize = ProductPackSize::where('product_id', $id)->delete();
        $path =  public_path('uploads/images/product/'.$product->image);

        try{
            if ($product->image=='company_logo.png') {
                $product->delete();
            } else {
                if (file_exists($path)) {
                    unlink($path);
                    $product->delete();
                } else {
                    $product->delete();
                }
            }
            Alert::success('Success','Successfully Deleted');
            return redirect()->back();
        }catch (\Exception $ex) {
            Alert::error('Oops...','Delete Failed');
            return back();
        }
    }

    public function productSize()
    {
        $productSize = PackSize::where('type', 1)->get();
        $size = '';
        $size .= '<option value="0">Select</option>';
        foreach ($productSize as $sub) {
            $size .= '<option value="'.$sub->size.'">'.$sub->size.'</option>';
        }
        return json_encode(['productSize' => $productSize,'size'=>$size]);
    }
}
