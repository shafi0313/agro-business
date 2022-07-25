<?php

namespace App\Http\Controllers\Backend;

use App\Models\Stock;
use App\Models\ProductStock;
use Illuminate\Http\Request;
use App\Models\PurchaseInvoice;
use App\Models\PurchaseLedgerBook;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class RepackUnitController extends Controller
{
    public function showAccpet()
    {
        if ($error = $this->authorize('repack-unit-qa/qc-manage')) {
            return $error;
        }
        $customerInfo = PurchaseInvoice::first();
        $getInvoice = PurchaseInvoice::where('type', 9)->latest()->get();
        $customerInvoices = $getInvoice->groupBy('challan_no');
        if($customerInfo == ''){
            alert()->info('Alert','There are no invoice. First create invoice');
            return redirect()->back();
        }
        return view('admin.repack_unit.check.customer_invoice_accpet', compact('customerInvoices','customerInfo'));
    }

    public function showInvoiceAccpet($challan_no)
    {
        if ($error = $this->authorize('repack-unit-qa/qc-show')) {
            return $error;
        }
        $showInvoices = PurchaseInvoice::where('challan_no', $challan_no)->where('type', 9)->get();
        $customerInfo = PurchaseInvoice::where('challan_no', $challan_no)->where('type', 9)->first();
        $total_amt = PurchaseLedgerBook::where('challan_no', $challan_no)->where('type', 9)->first();
        return view('admin.repack_unit.check.show_invoice_accpet', compact('showInvoices','customerInfo','total_amt'));
    }
    // For Check end

    public function store(Request $request)
    {
        if ($error = $this->authorize('repack-unit-qa/qc-accept-or-reject')) {
            return $error;
        }
        DB::beginTransaction();
        // For Status 1=Accept, 2=Reject
        foreach($request->id as $key => $v){
            PurchaseInvoice::where('id', $request->id[$key])->first()->update(['status' => $request->status]);
        }
        // return $request;
        $transaction_id = transaction_id('RPU');

        // Stock Update
        if($request->status == 1){
            foreach ($request->product_id as $key => $v) {
                $data=[
                    'tran_id' => $transaction_id,
                    'inv_id' => $request->id[$key],
                    'product_id' => $request->product_id[$key],
                    'product_pack_size_id' => $request->size[$key],
                    'type' => 9, //
                    'stock_type' => 2, //Bulk
                    'challan_no' => $request->challan_no,
                    'quantity' => $request->quantity[$key],
                    // 'bonus' => $request->bonus[$key],
                    'use_weight' => $request->net_weight[$key],
                    // 'amt' => round($request->amt[$key]) - round($request->amt[$key])*$request->pro_dis[$key]/100,
                    // 'dis' => $request->pro_dis[$key],
                    'net_amt' => 0,
                    'date' => $request->invoice_date,
                ];
                Stock::create($data);
            };

            foreach($request->quantity as $i => $qty){
                $stok = ProductStock::where('product_id', $request->product_id[$i])->where('product_pack_size_id', $request->size[$i])->where('type', 3)->first();

                $quantity   = $stok->quantity;
                $net_weight = $stok->net_weight;

                $stockUpdate['quantity']    = $quantity + $qty;
                $stockUpdate['net_weight']  = $net_weight + $request->net_weight[$i];

                $stok->update($stockUpdate);
            }
        }else{
            foreach($request->quantity as $i => $qty){
                $stok = ProductStock::where('product_id', $request->product_id[$i])->where('product_pack_size_id', $request->size[$i])->where('type', 2)->first();

                $quantity   = $stok->quantity;
                $net_weight = $stok->net_weight;

                $stockUpdate['quantity']    = $quantity + $qty;
                $stockUpdate['net_weight']  = $net_weight + $request->net_weight[$i];

                $stok->update($stockUpdate);
            }
        }

        try {
            DB::commit();
            toast('Accepted','success');
            return redirect()->route('repackingCheck.showAccpet');
        } catch (\Exception $ex) {
            toast($ex->getMessage().'Failed','error');
            return back();
        }
    }
}
