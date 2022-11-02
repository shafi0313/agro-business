<?php

namespace App\Http\Controllers\Backend;

use App\Models\Product;
use App\Models\PackSize;
use App\Models\ProductStock;
use Illuminate\Http\Request;
use App\Models\ProductPackSize;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use RealRashid\SweetAlert\Facades\Alert;

class RawMaterialController extends Controller
{
    public function index()
    {
        if ($error = $this->authorize('bulk-name-manage')) {
            return $error;
        }
        $porducts = Product::where('type', 2)->orderBy('generic','ASC')->get();
        return view('admin.bulk.product.index', compact('porducts'));
    }

    public function create()
    {
        if ($error = $this->authorize('bulk-name-add')) {
            return $error;
        }
        $packSizes = PackSize::where('type', 2)->get();
        return view('admin.bulk.product.create', compact('packSizes'));
    }

    public function store(Request $request)
    {
        if ($error = $this->authorize('bulk-name-add')) {
            return $error;
        }
        $this->validate($request, [
            'generic' => 'required',
        ]);

        DB::beginTransaction();
        $data = [
            'name' => $request->get('name'),
            'generic' => $request->get('generic'),
            'indications' => $request->get('indications'),
            'dosage' => $request->get('dosage'),
            // 'origin' => $request->get('origin'),
            'type' => 2,
        ];
        $porduct = Product::create($data);

        foreach($request->size as $key => $v){
            $data=[
                'product_id' => $porduct->id,
                'size' => $request->size[$key],
                'purchase' => $request->purchase[$key],
                'trade_price' => $request->trade_price[$key],
                // 'mrp' => $request->mrp[$key],
                'type' => 2, // Bulk Stock
            ];
            $productPackSize = ProductPackSize::create($data);

            $productStock = [
                'product_id' => $porduct->id,
                'product_pack_size_id' => $productPackSize->id,
                'quantity' => 0,
                'damage' => 0,
                'type' => 2, // Bulk Stock
            ];
            $productStocks = ProductStock::create($productStock);

            // For Stock
            $productStock = [
                'product_id' => $porduct->id,
                'product_pack_size_id' => $productPackSize->id,
                'quantity' => 0,
                'damage' => 0,
                'type' => 3, // Factory Stock
            ];
            $productStocks = ProductStock::create($productStock);
        }

        try {
            $porduct == true;
            $productPackSize == true;
            $productStocks == true;
            DB::commit();
            toast('Bulk Successfully Inserted','success');
            return redirect()->route('raw-material.index');
        } catch (\Exception $ex) {
            DB::rollBack();
            toast('Bulk Inserted Failed','error');
            return back();
        }
    }

    public function addSizePrice(Request $request)
    {
        if ($error = $this->authorize('bulk-name-add')) {
            return $error;
        }
        $this->validate($request,[
            'size' => 'required',
            'purchase' => 'required',
            'trade_price' => 'required',
            'mrp' => 'required',
        ]);

        DB::beginTransaction();

        $product_id = $request->get('product_id');
        foreach($request->size as $key => $v){
            $data=[
                'product_id' => $product_id,
                'size' => $request->size[$key],
                'purchase' => $request->purchase[$key],
                'trade_price' => $request->trade_price[$key],
                'mrp' => $request->mrp[$key],
                'type' => 2,
            ];
            $productPackSize = ProductPackSize::create($data);

            $productStock = [
                'product_id' => $product_id,
                'product_pack_size_id' => $productPackSize->id,
                'quantity' => 0,
                'type' => 2,
            ];
            ProductStock::create($productStock);
        }

        try {
            $productPackSize == true;
            DB::commit();
            toast('New Size Successfully Inserted','success');
            return redirect()->back();
        } catch (\Exception $ex) {
            DB::rollBack();
            toast('New Size Inserted Failed', 'error');
            return redirect()->back();
        }
    }

    public function edit($id)
    {
        if ($error = $this->authorize('bulk-name-edit')) {
            return $error;
        }
        $packSizess = PackSize::where('type', 2)->get();
        $product = Product::find($id);
        $packSizes = ProductPackSize::where('product_id', $id)->where('type', 2)->get();
        return view('admin.bulk.product.edit', compact('product','packSizes','packSizess'));
    }

    public function update(Request $request, $id)
    {
        if ($error = $this->authorize('bulk-name-edit')) {
            return $error;
        }
        $data = [
            'name' => $request->get('name'),
            'generic' => $request->get('generic'),
            'indications' => $request->get('indications'),
            'dosage' => $request->get('dosage'),
            'origin' => $request->get('origin'),
            'type' => 2,
        ];

        DB::beginTransaction();
        try {
            $update  = Product::find($id);
            $update->update($data);
            if (count($request->id) > 0) {
                foreach ($request->id as $key => $v) {
                    $packData=[
                        'size' => $request->size[$key],
                        'purchase' => $request->purchase[$key],
                        'trade_price' => $request->trade_price[$key],
                        'type' => 2,
                    ];
                    $pack = ProductPackSize::where('id', $request->id[$key])->first();
                    $pack->update($packData);
                }
            }
            DB::commit();
            toast('Bulk Successfully Updated','success');
            return redirect()->route('raw-material.index');
        } catch(\Exception $ex) {
            DB::rollBack();
            toast($ex->getMessage().'Bulk Update Failed','error');
            return redirect()->back();
        }
    }


    public function deletePackSize($packId)
    {
        if ($error = $this->authorize('bulk-name-delete')) {
            return $error;
        }
        ProductPackSize::findOrFail($packId)->delete();
        toast('Product Size Successfully Inserted','success');
        return redirect()->back();
    }

    public function destroy($id)
    {
        if ($error = $this->authorize('bulk-name-delete')) {
            return $error;
        }
        try{
            Product::find($id)->delete();
            Alert::success('Success','Successfully Deleted');
            return redirect()->back();
        }catch (\Exception $ex) {
            Alert::error('Oops...','Delete Failed');
            return back();
        }
    }

    public function productSize(Request $request)
    {
        $productSize = PackSize::where('type', 2)->get();
        $size = '';
        $size .= '<option value="0">Select</option>';
        foreach($productSize as $sub){
            $size .= '<option value="'.$sub->size.'">'.$sub->size.'</option>';
        }
        return json_encode(['productSize' => $productSize,'size'=>$size]);
    }
}
