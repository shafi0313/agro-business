<?php

namespace App\Http\Controllers\Backend;

use App\Models\User;
use App\Models\Stock;
use App\Models\ProductStock;
use Illuminate\Http\Request;
use App\Models\PurchaseInvoice;
use App\Models\PurchaseLedgerBook;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class SendToRepackingController extends Controller
{
    public function index()
    {
        $suppliers  = User::where('role', 4)->get();
        return view('admin.bulk.send_to_repacking.index', compact('suppliers'));
    }

    public function createId($id)
    {
        if ($error = $this->sendPermissionError('create')) {
            return $error;
        }
        $supplier  = User::find($id);
        $userId = User::select(['id','tmm_so_id','name'])->where('role', 1)->orwhere('role', 5)->get();
        $getChallan_no = PurchaseInvoice::select(['challan_no','type'])->withTrashed()->where('type', 9)->orwhere('type', 3)->get();
        $challan_no = $getChallan_no->groupBy('challan_no')->count() + 145;
        $ledger = PurchaseLedgerBook::where('supplier_id', $id)->orderBy('id','DESC')->get();
        $ledgerPayment = PurchaseLedgerBook::select(['id','payment'])->get();
        return view('admin.bulk.send_to_repacking.create', compact('supplier','challan_no','userId','ledger','ledgerPayment'));
    }

    public function store(Request $request)
    {
        // return $request;
       $this->validate($request,[
            'challan_no' => 'required',
            'size' => 'required',
            'quantity' => 'required',
            // 'rate_per_qty' => 'required',
            // 'amt' => 'required',
        ]);

        DB::beginTransaction();

        $supplier_id = $request->get('supplier_id');
        $invoice_no = $request->get('invoice_no');
        $challan_no = $request->get('challan_no');
        $user_id = $request->get('user_id');
        $invoice_date = $request->get('invoice_date');
        $transaction_id = transaction_id('STR');

        // Sales Invoice Start
        $invoiceArr = [];
        foreach($request->product_id as $key => $v){
            $data=[
                'tran_id' => $transaction_id,
                'user_id' => $user_id,
                'supplier_id' => $supplier_id,
                'product_id' => $request->product_id[$key],
                'type' => 9, // Send to Repack
                'status' => 0, // Check
                'invoice_no' => $invoice_no,
                'challan_no' => $challan_no,
                'size' => $request->size[$key],
                'quantity' => $request->quantity[$key],
                // 'bonus' => $request->bonus[$key],
                // 'rate_per_qty' => $request->rate_per_qty[$key],
                'net_weight' => $request->net_weight[$key],
                // 'discount' => $request->discount[$key],
                'amt' => 0,
                'invoice_date' => $invoice_date,
            ];
            $invoice = PurchaseInvoice::create($data);
            $invoiceArr[] = $invoice->id;
        };
        // Sales Invoice End

        foreach($request->quantity as $i => $qty){
            $stok = ProductStock::where('product_id', $request->product_id[$i])->where('product_pack_size_id', $request->size[$i])->where('type', 2)->first();

            $quantity   = $stok->quantity;
            $net_weight = $stok->net_weight;

            $stockUpdate['quantity']    = $quantity - $qty;
            $stockUpdate['net_weight']  = $net_weight - $request->net_weight[$i];

            $stok->update($stockUpdate);
        }
        // Bulk Store End


        // Sales Ledger Book Start
        $ledgerBook = [
            'tran_id' => $transaction_id,
            'user_id' => $user_id,
            'supplier_id' => $supplier_id,
            'prepared_id' => auth()->user()->id,
            'type' => 9, // Send to Repack
            'invoice_no' => $invoice_no,
            'challan_no' => $challan_no,
            'purchase_amt' => 0,
            // 'discount' => $request->get('discount'),
            // 'net_weight' => $request->get('net_weight'),
            // 'net_amt' => $request->get('net_amt'),
            // 'payment' => $request->get('payment'),
            // 'payment_date' =>  $request->get('payment_date'),
            'user_type' =>  $request->get('user_type'),
            'invoice_date' => $invoice_date,
            // 'delivery_date' => $request->get('delivery_date'),
        ];

        try {
            $ledgerBook = PurchaseLedgerBook::create($ledgerBook);
            $invoice == true;
            DB::commit();
            toast('Sales Invoice Successfully Inserted','success');
            return redirect()->route('send-to-repack-unit.index');
        } catch (\Exception $ex) {
            DB::rollBack();
            toast($ex->getMessage().'Sales Invoice Inserted Failed','error');
            return back();
        }
    }

    // Customer Invoice Show
    public function show($id)
    {
        $supplierInfo = PurchaseInvoice::where('supplier_id', $id)->first();
        $getInvoice = PurchaseInvoice::where('supplier_id', $id)->latest()->get();
        $invoices = $getInvoice->groupBy('challan_no');
        if($supplierInfo == ''){
            alert()->info('Alert','There are no invoice. First create invoice');
            return redirect()->back();
        }
        return view('admin.bulk.send_to_repacking.customer_invoice', compact('invoices','supplierInfo'));
    }

    // Stock Check
    public function bulkStockCheck(Request $request)
    {
        $product_id = $request->product_id;
        $size_id = $request->size_id;

        $totalStock = Stock::where('product_id', $product_id)->where('product_pack_size_id', $size_id)->where('stock_type',2)->where('inv_cancel',0)->whereIn('type', ['00','7'])->sum('quantity');
        $totalOut = Stock::where('product_id', $product_id)->where('product_pack_size_id', $size_id)->where('stock_type',2)->where('inv_cancel',0)->whereIn('type',['9','16'])->sum('quantity');
        $quantity =  $totalStock - $totalOut;
        return json_encode(['quantity'=>$quantity]);
    }

    // Invoice Details
    public function showInvoice($supplier_id, $challan_no)
    {
        $showInvoices = PurchaseInvoice::where('supplier_id', $supplier_id)->where('challan_no', $challan_no)->get();
        $supplierInfo = PurchaseInvoice::where('supplier_id', $supplier_id)->first();
        $total_amt = PurchaseLedgerBook::where('challan_no',$challan_no)->first();
        return view('admin.bulk.send_to_repacking.show_invoice', compact('showInvoices','supplierInfo','total_amt'));
    }

    public function printChallan($supplier_id, $challan_no)
    {
        $getShowInvoices = PurchaseInvoice::where('supplier_id', $supplier_id)->where('challan_no', $challan_no)->where('type', 9)->get();
        $showInvoices = $getShowInvoices->groupby('product_id');
        $ledger = PurchaseLedgerBook::where('challan_no', $challan_no)->first();
        return view('admin.bulk.send_to_repacking.print_challan', compact('showInvoices','ledger'));
    }

     // Soft Delete
    public function destroyInvoice($invoice_no)
    {
        if ($error = $this->sendPermissionError('delete')) {
            return $error;
        }
        PurchaseInvoice::where('invoice_no',$invoice_no)->delete();
        PurchaseLedgerBook::where('invoice_no',$invoice_no)->delete();
        if(PurchaseInvoice::count() < 1){
            toast('Sales Invoice Successfully Deleted','success');
            return redirect()->route('invoice.index');
        }else{
            toast('Sales Invoice Successfully Deleted','success');
            return redirect()->back();
        }
    }

    public function destroy(Request $request, $id)
    {
        if ($error = $this->sendPermissionError('delete')) {
            return $error;
        }
        PurchaseInvoice::find($id)->delete();
        $invoice_no = $request->get('invoice_no');
        $customer_id = $request->get('customer_id');
        $invoices = PurchaseInvoice::select('amt')->where('invoice_no', $invoice_no)->where('customer_id', $customer_id)->get()->sum('amt');

        $ledgerBooks = PurchaseLedgerBook::where('invoice_no', $invoice_no)->where('customer_id', $customer_id)->get();

        foreach($ledgerBooks as $ledgerBook)
        {
            $courier_pay = $ledgerBook->courier_pay;
            $payment = $ledgerBook->payment;
        }

        $ledgerUpdate = [
            'total_amt' =>$invoices,
            'dues_amt' =>$invoices - $courier_pay - $payment,
        ];
        PurchaseLedgerBook::where('invoice_no', $invoice_no)->where('customer_id', $customer_id)->update($ledgerUpdate);
        return redirect()->back();
    }
}
