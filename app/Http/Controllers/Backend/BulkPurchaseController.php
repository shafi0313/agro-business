<?php

namespace App\Http\Controllers\Backend;

use App\Models\User;
use App\Models\Stock;
use Illuminate\Http\Request;
use App\Models\PurchaseInvoice;
use App\Models\SalesLedgerBook;
use App\Models\PurchaseLedgerBook;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class BulkPurchaseController extends Controller
{
    public function index()
    {
        $suppliers = User::select(['id','name','tmm_so_id','business_name','phone','address','role'])->where('role', 3)->orderby('business_name', 'ASC')->get();
        return view('admin.bulk.purchase.index', compact('suppliers'));
    }

    public function createId($id)
    {
        if ($error = $this->sendPermissionError('create')) {
            return $error;
        }
        $userId = User::select(['id','tmm_so_id','role','name'])->where('role', 1)->where('name', '!=', 'Developer')->orwhere('role', 5)->get();
        $supplier = User::select(['id','name','email','phone','address'])->find($id);
        return view('admin.bulk.purchase.create', compact('supplier', 'userId', ));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'challan_no' => 'required',
            'size' => 'required',
            'quantity' => 'required',
            'rate_per_qty' => 'required',
            'amt' => 'required',
            'invoice_date' => 'required',
        ]);

        $supplier_id = $request->get('supplier_id');
        $invoice_no = $request->get('invoice_no');
        $challan_no = $request->get('challan_no');
        $user_id = $request->get('user_id');
        $invoice_date = $request->invoice_date;
        $transaction_id = transaction_id('BPU');

        DB::beginTransaction();

        $invoiceArr = [];
        // Purchase Invoice Start
        foreach ($request->product_id as $key => $v) {
            $data=[
                'tran_id' => $transaction_id,
                'user_id' => $user_id,
                'supplier_id' => $supplier_id,
                'product_id' => $request->product_id[$key],
                'type' => 7, // Purchase Bulk
                'status' => 1,
                'invoice_no' => $invoice_no,
                'challan_no' => $challan_no,
                'size' => $request->size[$key], // weight
                'quantity' => $request->quantity[$key],
                'rate_per_qty' => $request->rate_per_qty[$key],
                'net_weight' => $request->net_weight[$key],
                'amt' => round($request->amt[$key]),
                'invoice_date' => $invoice_date,
            ];
            $invoice = PurchaseInvoice::create($data);
            $invoiceArr[] = $invoice->id;
        }

        // Purchase Invoice End

        // Bulk Store Start
        foreach ($request->product_id as $key => $v) {
            $data=[
                'tran_id' => $transaction_id,
                'inv_id' => $invoiceArr[$key],
                'product_id' => $request->product_id[$key],
                'product_pack_size_id' => $request->size[$key],
                'type' => 7, // Bulk Purchase
                'stock_type' => 2, //Bulk
                'challan_no' => $challan_no,
                'quantity' => $request->quantity[$key],
                // 'bonus' => $request->bonus[$key],
                'net_weight' => $request->net_weight[$key],
                // 'amt' => round($request->amt[$key]) - round($request->amt[$key])*$request->pro_dis[$key]/100,
                // 'dis' => $request->pro_dis[$key],
                'net_amt' => round($request->amt[$key]),
                'date' => $request->invoice_date,
            ];
            Stock::create($data);
        };

        // Purchase Ledger Book Start
        $ledgerBook = [
            'tran_id' => $transaction_id,
            'user_id' => $user_id,
            'supplier_id' => $supplier_id,
            'prepared_id' => auth()->user()->id,
            'type' => 7,
            'invoice_no' => $invoice_no,
            'challan_no' => $challan_no,
            'purchase_amt' => $request->get('total_amt'),
            'discount' => $request->get('discount'),
            'net_amt' => round($request->get('net_amt')),
            'payment' => round($request->get('payment')),
            'payment_date' =>  $request->get('payment_date'),
            'user_type' =>  $request->get('user_type'),
            'invoice_date' =>$invoice_date,
            'delivery_date' => $request->get('delivery_date'),
        ];
        // Purchase Ledger Book End

        try {
            $ledgerBook = PurchaseLedgerBook::create($ledgerBook);
            $invoice == true;
            // $stockUpdate== true;
            DB::commit();
            toast('Purchase Bulk Successfully Inserted', 'success');
            return redirect()->route('purchase-bulk.index');
        } catch (\Exception $ex) {
            DB::rollBack();
            toast($ex->getMessage().'Purchase Bulk Inserted Faild', 'error');
            return back();
        }
    }

    // Customer Invoice Show
    public function show($id)
    {
        $supplierInfo = PurchaseInvoice::where('supplier_id', $id)->first();
        $getChallan = PurchaseInvoice::where('supplier_id', $id)->latest()->get();
        $supplierChallans = $getChallan->groupBy('challan_no');
        if ($supplierInfo == '') {
            alert()->info('Alert', 'There are no invoice. First create invoice');
            return redirect()->back();
        }
        return view('admin.bulk.purchase.customer_invoice', compact('supplierChallans', 'supplierInfo'));
    }

    // Invoice Details
    public function showInvoice($supplier_id, $challan_no)
    {
        $showInvoices = PurchaseInvoice::where('supplier_id', $supplier_id)->where('challan_no', $challan_no)->where('type', 7)->get(); // 7 = Purchase Bulk
        $supplierInfo = PurchaseInvoice::where('supplier_id', $supplier_id)->where('challan_no', $challan_no)->where('type', 7)->first();
        return view('admin.bulk.purchase.ind_show_invoice', compact('showInvoices', 'supplierInfo'));
    }

    // All
    public function allInvoice()
    {
        $getChallan = PurchaseInvoice::where('type', 7)->latest()->get();
        $supplierChallans = $getChallan->groupBy('challan_no');

        return view('admin.bulk.purchase.all_invoice', compact('supplierChallans'));
    }

    public function allInvoiceShow($challan_no)
    {
        $showInvoices = PurchaseInvoice::where('challan_no', $challan_no)->where('type', 7)->get(); // 7 = Purchase Bulk
        $supplierInfo = PurchaseInvoice::where('challan_no', $challan_no)->where('type', 7)->first();
        return view('admin.bulk.purchase.all_invoice_show', compact('showInvoices', 'supplierInfo'));
    }

    public function selectDate()
    {
        return view('admin.bulk.purchase.all_select_date');
    }

    public function allInvoiceByDate(Request $request)
    {
        $form_date = $request->get('form_date');
        $to_date = $request->get('to_date');

        $getChallan = PurchaseInvoice::whereBetween('invoice_date', [$form_date,$to_date])->where('type', 7)->latest()->get();
        $supplierChallans = $getChallan->groupBy('challan_no');
        return view('admin.bulk.purchase.all_invoice_by_date', compact('supplierChallans'));
    }

    public function allInvoiceShowByDate($challan_no)
    {
        $showInvoices = PurchaseInvoice::where('challan_no', $challan_no)->where('type', 7)->get(); // 7 = Purchase Bulk
        $supplierInfo = PurchaseInvoice::where('challan_no', $challan_no)->where('type', 7)->first();
        return view('admin.bulk.purchase.all_invoice_show_by_date', compact('showInvoices', 'supplierInfo'));
    }


    // Print
    public function printInvoice($supplier_id, $challan_no)
    {
        $getShowInvoices = PurchaseInvoice::where('supplier_id', $supplier_id)->where('challan_no', $challan_no)->where('type', 7)->get();
        $showInvoices = $getShowInvoices->groupBy('product_id');
        $ledger = PurchaseLedgerBook::where('challan_no', $challan_no)->first();
        return view('admin.bulk.purchase.print_invoice', compact('showInvoices', 'ledger', 'getShowInvoices'));
    }

    public function printChallan($supplier_id, $challan_no)
    {
        $getShowInvoices = PurchaseInvoice::where('supplier_id', $supplier_id)->where('challan_no', $challan_no)->where('type', 7)->get();
        $showInvoices = $getShowInvoices->groupBy('product_id');
        $ledger = PurchaseLedgerBook::where('challan_no', $challan_no)->first();
        return view('admin.bulk.purchase.print_challan', compact('showInvoices', 'ledger'));
    }

    public function destroyInvoice($challan_no)
    {
        if ($error = $this->sendPermissionError('delete')) {
            return $error;
        }
        PurchaseInvoice::where('challan_no', $challan_no)->delete();
        PurchaseLedgerBook::where('challan_no', $challan_no)->delete();
        if (PurchaseInvoice::count() < 1) {
            toast('Invoice Successfully Deleted', 'success');
            return redirect()->route('purchase-invoice.index');
        } else {
            toast('Invoice Successfully Deleted', 'success');
            return redirect()->back();
        }
    }

    public function destroy(Request $request, $id)
    {
        PurchaseInvoice::find($id)->delete();
        $amt = 0;
        $invoice_no = $request->get('invoice_no');
        $customer_id = $request->get('customer_id');
        $invoices = PurchaseInvoice::select('amt')->where('invoice_no', $invoice_no)->where('customer_id', $customer_id)->get()->sum('amt');

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
