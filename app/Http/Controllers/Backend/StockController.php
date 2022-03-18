<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\ProductStock;
use Illuminate\Http\Request;

class StockController extends Controller
{
    // Repack Stock ___________________________________________________________________________
    public function repackStockIndex()
    {
        $stocks = ProductStock::get()->sortBy(function($query){
            return $query->product->generic;
         })->where('type',3)->all();
        return view('admin.repack_unit.stock.index', compact('stocks'));
    }

    public function repackStockEdit($id)
    {
        if ($error = $this->sendPermissionError('edit')) {
            return $error;
        }
        $stock = ProductStock::find($id);
        return view('admin.repack_unit.stock.edit', compact('stock'));
    }

    public function repackStockUpdate(Request $request, $id)
    {
        $data = $this->validate($request,[
            'quantity' => 'sometimes|numeric',
            'net_weight' => 'sometimes|numeric',
            'damage' => 'sometimes|numeric',
        ]);

        try {
            ProductStock::find($id)->update($data);
            toast('Stock Successfully Updated','success');
            return back();
        } catch (\Exception $ex) {
            toast($ex->getMessage().'Stock Update Failed','error');
            return back();
        }
    }



    // Label Stock
    public function labelStockIndex()
    {
        $stocks = ProductStock::where('type', 4)->get();
        return view('admin.label.stock.index', compact('stocks'));
    }

    public function labelStockEdit($id)
    {
        if ($error = $this->sendPermissionError('edit')) {
            return $error;
        }
        $stock = ProductStock::find($id);
        return view('admin.label.stock.edit', compact('stock'));
    }

    public function labelStockUpdate(Request $request, $id)
    {
        $data = $this->validate($request,[
            // 'quantity' => 'sometimes|numeric',
            'net_weight' => 'sometimes|numeric',
            'damage' => 'sometimes|numeric',
        ]);

        try {
            ProductStock::find($id)->update($data);
            toast('Stock Successfully Updated','success');
            return back();
        } catch (\Exception $ex) {
            toast($ex->getMessage().'Stock Update Faild','error');
            return back();
        }
    }
}
