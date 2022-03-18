<?php

namespace App\Http\Controllers\Backend;

use Carbon\Carbon;
use App\Models\User;
use App\Models\InvoiceDue;
use App\Models\ProductStock;
use App\Models\SalesInvoice;
use Illuminate\Http\Request;
use App\Models\PurchaseInvoice;
use App\Models\SalesLedgerBook;
use App\Models\PurchaseLedgerBook;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class LabelSendToRepackingController extends Controller
{
    public function index()
    {
        $suppliers  = User::where('role', 4)->get();
        return view('admin.label.send_to_repacking.index', compact('suppliers'));
    }

    public function createId($id)
    {
        if ($error = $this->sendPermissionError('create')) {
            return $error;
        }
        $supplier  = User::find($id);
        $userId = User::select(['id','tmm_so_id','role'])->where('role', 1)->get();
        $getChallan_no = PurchaseInvoice::select(['challan_no','type'])->withTrashed()->where('type', 9)->orwhere('type', 3)->get();
        $challan_no = $getChallan_no->groupBy('challan_no')->count() + 101;

        $ledger = PurchaseLedgerBook::where('supplier_id', $id)->orderBy('id', 'DESC')->get();
        $ledgerPayment = PurchaseLedgerBook::select(['id','payment'])->get();
        return view('admin.label.send_to_repacking.create', compact('supplier', 'challan_no', 'userId', 'ledger', 'ledgerPayment'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'challan_no' => 'required',
            'size' => 'required',
        ]);

        DB::beginTransaction();

        $supplier_id = $request->get('supplier_id');
        $invoice_no = $request->get('invoice_no');
        $challan_no = $request->get('challan_no');
        $user_id = $request->get('user_id');

        // Sales Invoice Start
        foreach ($request->product_id as $key => $v) {
            $data=[
                'user_id' => $user_id,
                'supplier_id' => $supplier_id,
                'product_id' => $request->product_id[$key],
                'type' => 15, // Label Send to Repack
                'status' => 1,
                'challan_no' => $challan_no,
                'size' => $request->size[$key], // weight
                'quantity' => $request->per_kg[$key],
                'rate_per_qty' => $request->rate_per_qty[$key],
                'net_weight' => $request->net_weight[$key],
                'amt' => $request->amt[$key],
                'invoice_date' => Carbon::now(),
            ];
            $invoice = PurchaseInvoice::create($data);
        };
        // Sales Invoice End

        // Label Store Start
        foreach ($request->per_kg as $i => $qty) {
            $stok = ProductStock::where('product_id', $request->product_id[$i])->where('product_pack_size_id', $request->size[$i])->where('type', 4)->first();

            $per_kg   = $stok->per_kg;
            $net_weight = $stok->net_weight;
            $amt        = $stok->amt;

            $stockUpdate['quantity']    = $qty - $per_kg;
            $stockUpdate['net_weight']  = $request->net_weight[$i] - $net_weight;
            $stockUpdate['amt']         = $request->amt[$i] - $amt;

            $stok->update($stockUpdate);
        }
        // Bulk Store End

        // Label Ledger Book Start
        $ledgerBook = [
            'user_id' => $user_id,
            'supplier_id' => $supplier_id,
            'prepared_id' => auth()->user()->id,
            'type' => 9, // Cash
            'invoice_no' => $invoice_no,
            'challan_no' => $challan_no,
            'purchase_amt' => 0,
            'discount' => $request->get('discount'),
            // 'net_weight' => $request->get('net_weight'),
            'net_amt' => $request->get('net_amt'),
            'payment' => $request->get('payment'),
            'payment_date' =>  $request->get('payment_date'),
            'user_type' =>  $request->get('user_type'),
            'invoice_date' => Carbon::now(),
            'delivery_date' => $request->get('delivery_date'),
        ];
        // Sales Ledger Book End

        // Invoice Due Start
        if ($request->inv_date != '') {
            $this->validate($request, [
                'inv_date' => 'required',
                'inv_amt' => 'required',
                'inv_payment' => 'required',
                'inv_total' => 'required',
            ]);
            foreach ($request->inv_date as $key => $v) {
                $invoiceDue=[
                    'invoice_no' => $invoice_no,
                    'inv_date' => $request->inv_date[$key],
                    'inv_amt' => $request->inv_amt[$key],
                    'inv_payment' => $request->inv_payment[$key],
                    'inv_total' => $request->inv_total[$key],
                ];
                InvoiceDue::create($invoiceDue);
            };
        }
        // Invoice Due End

        try {
            $ledgerBook = PurchaseLedgerBook::create($ledgerBook);
            $invoice == true;
            DB::commit();
            toast('Send Successfully Inserted', 'success');
            return redirect()->route('label-send-to-repack-unit.index');
        } catch (\Exception $ex) {
            DB::rollBack();
            toast($ex->getMessage().'Send Inserted Faild', 'error');
            return back();
        }
    }

    // Customer Invoice Show
    public function show($id)
    {
        $supplierInfo = PurchaseInvoice::where('supplier_id', $id)->first();
        $getInvoice = PurchaseInvoice::where('supplier_id', $id)->latest()->get();
        $invoices = $getInvoice->groupBy('challan_no');
        if ($supplierInfo == '') {
            alert()->info('Alert', 'There are no invoice. First create invoice');
            return redirect()->back();
        }
        return view('admin.label.send_to_repacking.customer_invoice', compact('invoices', 'supplierInfo'));
    }

    // Stock Check
    public function bulkStockCheck(Request $request)
    {
        $product_id = $request->product_id;
        $size_id = $request->size_id;
        $stockQuantity = ProductStock::where('product_id', $product_id)->where('product_pack_size_id', $size_id)->where('type', 2)->first();
        $quantity =  $stockQuantity->quantity;

        return json_encode(['quantity'=>$quantity]);
    }

    // Invoice Details
    public function showInvoice($supplier_id, $challan_no)
    {
        $showInvoices = PurchaseInvoice::where('supplier_id', $supplier_id)->where('challan_no', $challan_no)->get();
        $supplierInfo = PurchaseInvoice::where('supplier_id', $supplier_id)->first();
        $total_amt = PurchaseLedgerBook::where('challan_no', $challan_no)->first();
        return view('admin.label.send_to_repacking.show_invoice', compact('showInvoices', 'supplierInfo', 'total_amt'));
    }

    public function printInvoice($customer_id, $invoice_no)
    {
        $showInvoices = SalesInvoice::where('customer_id', $customer_id)->where('invoice_no', $invoice_no)->where('type', 1)->get();
        $customerInfo = SalesInvoice::where('customer_id', $customer_id)->first();
        $invoiceDue = InvoiceDue::where('invoice_no', $invoice_no)->get();
        $invoiceDueFirst = InvoiceDue::where('invoice_no', $invoice_no)->first();
        $ledger = SalesLedgerBook::where('invoice_no', $invoice_no)->first();
        return view('admin.label.send_to_repacking.print', compact('showInvoices', 'customerInfo', 'invoiceDue', 'ledger', 'invoiceDueFirst'));
    }

    // Soft Delete
    public function destroyInvoice($invoice_no)
    {
        if ($error = $this->sendPermissionError('delete')) {
            return $error;
        }
        SalesInvoice::where('invoice_no', $invoice_no)->delete();
        SalesLedgerBook::where('invoice_no', $invoice_no)->delete();
        if (SalesInvoice::count() < 1) {
            toast('Sales Invoice Successfully Deleted', 'success');
            return redirect()->route('invoice.index');
        } else {
            toast('Sales Invoice Successfully Deleted', 'success');
            return redirect()->back();
        }
    }

    public function destroy(Request $request, $id)
    {
        if ($error = $this->sendPermissionError('delete')) {
            return $error;
        }
        SalesInvoice::find($id)->delete();
        $invoice_no = $request->get('invoice_no');
        $customer_id = $request->get('customer_id');
        $invoices = SalesInvoice::select('amt')->where('invoice_no', $invoice_no)->where('customer_id', $customer_id)->get()->sum('amt');

        $ledgerBooks = SalesLedgerBook::where('invoice_no', $invoice_no)->where('customer_id', $customer_id)->get();

        foreach ($ledgerBooks as $ledgerBook) {
            $courier_pay = $ledgerBook->courier_pay;
            $payment = $ledgerBook->payment;
        }

        $ledgerUpdate = [
            'total_amt' =>$invoices,
            'dues_amt' =>$invoices - $courier_pay - $payment,
        ];
        SalesLedgerBook::where('invoice_no', $invoice_no)->where('customer_id', $customer_id)->update($ledgerUpdate);
        return redirect()->back();
    }
}
