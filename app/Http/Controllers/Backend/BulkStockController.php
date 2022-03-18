<?php

namespace App\Http\Controllers\Backend;

use App\Models\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;

class BulkStockController extends Controller
{
    public function index()
    {
        $stocks = Stock::where('stock_type', 2)->whereInv_cancel(0)->get();
        return view('admin.stock.bulk.index', compact('stocks'));
    }

    public function create()
    {
        if ($error = $this->sendPermissionError('create')) {
            return $error;
        }
        return view('admin.stock.bulk.create');
    }

    public function store(Request $request)
    {
        if ($error = $this->sendPermissionError('create')) {
            return $error;
        }
        $data=[
            'inv_id' => 0,
            'product_id' => $request->product_id,
            'product_pack_size_id' => $request->product_pack_size_id,
            'type' => $request->type, // Cash
            'stock_type' => 2, //Bulk
            'challan_no' => 0,
            'net_weight' => $request->net_weight,
            'quantity' => $request->quantity,
            // 'bonus' => $request->bonus,
            // 'amt' => round($request->amt) - round($request->amt)*$request->pro_dis/100,
            // 'dis' => $request->pro_dis,
            // 'net_amt' => round($request->amt),
            'date' => $request->invoice_date,
        ];
        DB::beginTransaction();
        try {
            DB::commit();
            Stock::create($data);
            toast('Sales Invoice Successfully Inserted', 'success');
            return redirect()->route('stock.bulk.index');
        } catch (\Exception $ex) {
            DB::rollBack();
            toast($ex->getMessage().'Sales Invoice Inserted Failed', 'error');
            return back();
        }
    }

    public function previous($packSize)
    {
        $stocks = Stock::where('product_pack_size_id', $packSize)->where('type', 00)->whereInv_cancel(0)->get();
        return view('admin.stock.bulk.previous', compact('stocks'));
    }

    public function update(Request $request)
    {
        if ($error = $this->sendPermissionError('edit')) {
            return $error;
        }
        $id = $request->id;
        $data=[
            'quantity' => $request->quantity,
            'net_weight' => $request->net_weight,
        ];
        try {
            Stock::find($id)->update($data);
            toast('Success', 'success');
            return redirect()->route('stock.bulk.index');
        } catch (\Exception $ex) {
            toast('Failed', 'error');
            return back();
        }
    }

    public function close(Request $request)
    {
        if ($error = $this->sendPermissionError('edit')) {
            return $error;
        }
        $product_id = $request->product_id;
        $pack_size_id = $request->pack_size_id;
        $password = $request->password;

        if (Hash::check($password, Auth::user()->password)) {
            Stock::where('product_id', $product_id)->where('product_pack_size_id', $pack_size_id)->where('stock_close', 0)->where('stock_type', 2)->update(['stock_close' => 1]);
            return back();
        } else {
            Alert::error('Password does not match');
            return back();
        }
    }
}
