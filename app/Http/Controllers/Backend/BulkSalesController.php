<?php

namespace App\Http\Controllers\Backend;

use App\Models\User;
use App\Models\Stock;
use App\Models\InvoiceDue;
use App\Models\SampleNote;
use App\Models\SalesInvoice;
use Illuminate\Http\Request;
use App\Models\PurchaseInvoice;
use App\Models\SalesLedgerBook;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class BulkSalesController extends Controller
{
    public function index()
    {
        if ($error = $this->authorize('bulk-sales-manage')) {
            return $error;
        }
        $customers = User::where('role', 2)->orderby('business_name', 'ASC')->get();
        return view('admin.bulk.sales.index', compact('customers'));
    }

    public function createId($id)
    {
        if ($error = $this->authorize('bulk-sales-sales')) {
            return $error;
        }
        $customer = User::find($id);
        $userId = User::select(['id','tmm_so_id','name'])->where('name', '!=', 'Developer')->whereIn('role', [1,5])->get();
        $invoice_no = SalesLedgerBook::select(['invoice_no','type'])->withTrashed()->whereIn('type', [16,18])->count() + 106;
        $ledgerPayment = SalesLedgerBook::with('customer')->select(['id','payment','net_amt'])->get();
        return view('admin.bulk.sales.create', compact('customer', 'invoice_no', 'userId', 'ledgerPayment'));
    }

    public function dueInvoice(Request $request)
    {
        $p_id = $request->cat_id;
        $dueInvoice = SalesLedgerBook::where('id', $p_id)->first();
        $invoice_date =  $dueInvoice->invoice_date;
        $net_amt =  $dueInvoice->net_amt;
        return json_encode(['dueInvoice' => $dueInvoice,'invoice_date'=>$invoice_date, 'net_amt'=>$net_amt]);
    }

    public function store(Request $request)
    {
        if ($error = $this->authorize('bulk-sales-sales')) {
            return $error;
        }
        $this->validate($request, [
            'invoice_no' => 'required',
            'size' => 'required',
            'quantity' => 'required',
            'rate_per_qty' => 'required',
            'amt' => 'required',
        ]);

        DB::beginTransaction();

        $customer_id = $request->get('customer_id');
        $invoice_no = $request->get('invoice_no');
        $challan_no = $request->get('challan_no');
        $user_id = $request->get('user_id');
        $invoice_date = $request->get('invoice_date');
        $transaction_id = transaction_id('BSE');

        // Sales Invoice Start
        $invoiceArr = [];
        foreach ($request->product_id as $key => $v) {
            $data=[
                'tran_id' => $transaction_id,
                'user_id' => $user_id,
                'customer_id' => $customer_id,
                'product_id' => $request->product_id[$key],
                'type' => $request->inv_type, // Cash
                'invoice_no' => $invoice_no,
                'challan_no' => $challan_no,
                'size' => $request->size[$key],
                'quantity' => $request->quantity[$key],
                // 'bonus' => $request->bonus[$key],
                'rate_per_qty' => $request->rate_per_qty[$key],
                // 'discount' => $request->discount[$key],
                'amt' => round($request->amt[$key]),
                'invoice_date' => $invoice_date,
            ];
            $invoice = SalesInvoice::create($data);
            $invoiceArr[] = $invoice->id;
        };
        // Sales Invoice End

        // Bulk Stock Start
        foreach ($request->product_id as $key => $v) {
            $data=[
                'tran_id' => $transaction_id,
                'inv_id' => $invoiceArr[$key],
                'product_id' => $request->product_id[$key],
                'product_pack_size_id' => $request->size[$key],
                'type' => 16, // Bulk Sales
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
        // foreach ($request->quantity as $i => $qty) {
        //     $stok = ProductStock::where('product_id', $request->product_id[$i])->where('product_pack_size_id', $request->size[$i])->where('type', 2)->first();
        //     $quantity   = $stok->quantity;
        //     $net_weight = $stok->net_weight;
        //     $stockUpdate['quantity']    = $quantity - $qty;
        //     $stockUpdate['net_weight']  = $net_weight - $request->net_weight[$i];
        //     $stok->update($stockUpdate);
        // }
        // Bulk Stock End

        $discount = array_sum($request->get('amt')) * $request->get('discount')/100;

        // Sales Ledger Book Start
        $ledgerBook = [
            'tran_id' => $transaction_id,
            'user_id' => $user_id,
            'customer_id' => $customer_id,
            'prepared_id' => auth()->user()->id,
            'type' => $request->inv_type,
            'invoice_no' => $invoice_no,
            'challan_no' => $challan_no,
            'sales_amt' => $request->get('total_amt'),
            'discount' => $request->get('discount'),
            'net_amt' => round($request->get('total_amt') - $discount),
            'payment' => round($request->get('payment')),
            'payment_date' =>  $request->get('payment_date'),
            // 'user_type' =>  $request->get('user_type'),
            'invoice_date' =>$invoice_date,
            'delivery_date' => $request->get('delivery_date'),
        ];
        $ledgerBook = SalesLedgerBook::create($ledgerBook);
        // Sales Ledger Book End

        // Invoice Due Start
        // if($request->inv_date != ''){
        //     $this->validate($request,[
        //         'inv_date' => 'required',
        //         'inv_amt' => 'required',
        //         'inv_payment' => 'required',
        //         'inv_total' => 'required',
        //     ]);
        //     foreach($request->inv_date as $key => $v){
        //         $invoiceDue=[
        //             'invoice_no' => $invoice_no,
        //             'inv_date' => $request->inv_date[$key],
        //             'inv_amt' => $request->inv_amt[$key],
        //             'inv_payment' => $request->inv_payment[$key],
        //             'inv_total' => $request->inv_total[$key],
        //         ];
        //         InvoiceDue::create($invoiceDue);
        //     };
        // }
        // Invoice Due End

        // $salesReport = SalesReport::where('user_id', $request->user_id)->first();
        // $report = [
        //     'user_id' => $salesReport->user_id,
        //     'type' => 1,
        //     'inv_type' => $request->inv_type,
        //     'sales_ledger_book_id' => $ledgerBook->id,
        //     'zsm_id' => $salesReport->zsm_id,
        //     'sso_id' => $salesReport->sso_id,
        //     'so_id' => $salesReport->so_id,
        //     'customer_id' => $customer_id,
        //     'invoice_date' => $request->invoice_date,
        //     'amt' => round(array_sum($request->get('amt')) - $discount),
        // ];
        // SalesReport::create($report);

        if ($request->note) {
            $sampleNote = [
                'sales_ledger_book_id' => $ledgerBook->id,
                'note' => $request->note,
                'tran_id' => $transaction_id,
            ];
            SampleNote::create($sampleNote);
        }

        try {
            DB::commit();
            toast('Success', 'success');
            return redirect()->route('sales-bulk.index');
        } catch (\Exception $ex) {
            DB::rollBack();
            toast($ex->getMessage().'Failed', 'error');
            return back();
        }
    }

    // Customer Invoice Show
    public function show($id)
    {
        if ($error = $this->authorize('bulk-sales-show')) {
            return $error;
        }
        $customerInfo = SalesInvoice::where('customer_id', $id)->first();
        $getInvoice = SalesInvoice::where('customer_id', $id)->whereIn('type', [16, 18])->latest()->get();
        $customerInvoices = $getInvoice->groupBy('invoice_no');
        if ($customerInfo == '') {
            alert()->info('Alert', 'There are no invoice. First create invoice');
            return redirect()->back();
        }
        return view('admin.bulk.sales.customer_invoice', compact('customerInvoices', 'customerInfo'));
    }

    // Invoice Details
    public function showInvoice($customer_id, $invoice_no)
    {
        if ($error = $this->authorize('bulk-sales-show')) {
            return $error;
        }
        $showInvoices = SalesInvoice::where('customer_id', $customer_id)->where('invoice_no', $invoice_no)->whereIn('type', [16, 18])->get();
        $customerInfo = SalesInvoice::where('customer_id', $customer_id)->first();
        $total_amt = SalesLedgerBook::where('invoice_no', $invoice_no)->first();
        return view('admin.bulk.sales.show_invoice', compact('showInvoices', 'customerInfo', 'total_amt'));
    }


    // All
    public function allInvoice()
    {
        if ($error = $this->authorize('bulk-sales-all-challan')) {
            return $error;
        }
        $getChallan = SalesInvoice::whereIn('type', [16, 18])->latest()->get();
        $supplierChallans = $getChallan->groupBy('challan_no');
        return view('admin.bulk.sales.all_invoice', compact('supplierChallans'));
    }

    public function allInvoiceShow($challan_no)
    {
        if ($error = $this->authorize('bulk-sales-all-challan')) {
            return $error;
        }
        $showInvoices = SalesInvoice::where('challan_no', $challan_no)->whereIn('type', [16, 18])->get(); // 7 = Purchase Bulk
        $supplierInfo = SalesInvoice::where('type', 7)->first();
        return view('admin.bulk.sales.all_invoice_show', compact('showInvoices', 'supplierInfo'));
    }

    public function selectDate()
    {
        if ($error = $this->authorize('bulk-sales-all-challan-by-date')) {
            return $error;
        }
        return view('admin.bulk.sales.select_date');
    }

    public function allInvoiceByDate(Request $request)
    {
        if ($error = $this->authorize('bulk-sales-all-challan-by-date')) {
            return $error;
        }
        $form_date = $request->get('form_date');
        $to_date = $request->get('to_date');

        $getChallan = SalesInvoice::whereBetween('invoice_date', [$form_date,$to_date])->whereIn('type', [16, 18])->latest()->get();
        $supplierChallans = $getChallan->groupBy('challan_no');
        return view('admin.bulk.sales.all_invoice_by_date', compact('supplierChallans'));
    }

    // Print
    public function printInvoice($customer_id, $invoice_no)
    {
        $getShowInvoices = SalesInvoice::where('customer_id', $customer_id)->where('invoice_no', $invoice_no)->whereIn('type', [16, 18])->get();
        $showInvoices = $getShowInvoices->groupBy('product_id');
        $ledger = SalesLedgerBook::with('preparedBy')->where('invoice_no', $invoice_no)->whereIn('type', [16, 18])->first();
        return view('admin.bulk.sales.print_invoice', compact('showInvoices', 'ledger', 'getShowInvoices'));
    }

    public function printChallan($customer_id, $invoice_no)
    {
        $getShowInvoices = SalesInvoice::where('customer_id', $customer_id)->where('invoice_no', $invoice_no)->whereIn('type', [16, 18])->get();
        $showInvoices = $getShowInvoices->groupBy('product_id');

        $invoiceDue = InvoiceDue::where('invoice_no', $invoice_no)->get();
        $invoiceDueFirst = InvoiceDue::where('invoice_no', $invoice_no)->first();
        $ledger = SalesLedgerBook::with('preparedBy')->where('invoice_no', $invoice_no)->whereIn('type', [16, 18])->first();
        return view('admin.bulk.sales.print_challan', compact('showInvoices', 'invoiceDue', 'ledger', 'invoiceDueFirst'));
    }

    //Bulk Report
    public function bulkSalesRepackChallan(Request $request)
    {
        if ($error = $this->authorize('bulk-report-send-sales-&-repack-unit-challan')) {
            return $error;
        }
        $form_date = $request->form_date;
        $to_date = $request->to_date;
        $getShowInvoices = SalesInvoice::whereBetween('invoice_date', [$form_date, $to_date])->whereIn('type', [16, 18])->get();
        $showInvoices = $getShowInvoices->groupBy('product_id');

        $getPurchaseInvoices = PurchaseInvoice::whereBetween('invoice_date', [$form_date, $to_date])->whereIn('type', [9])->get();
        $showPurchaseInvoices = $getPurchaseInvoices->groupBy('product_id');
        return view('admin.bulk.sales_repack_challan.print_challan', compact('showInvoices','showPurchaseInvoices','form_date','to_date'));
    }

    // Soft Delete
    // public function destroyInvoice($invoice_no)
    // {
    //     if ($error = $this->sendPermissionError('delete')) {
    //         return $error;
    //     }
    //     SalesInvoice::where('invoice_no', $invoice_no)->delete();
    //     SalesLedgerBook::where('invoice_no', $invoice_no)->delete();
    //     if (SalesInvoice::count() < 1) {
    //         toast('Sales Invoice Successfully Deleted', 'success');
    //         return redirect()->route('invoice.index');
    //     } else {
    //         toast('Sales Invoice Successfully Deleted', 'success');
    //         return redirect()->back();
    //     }
    // }

    // public function destroy(Request $request, $id)
    // {
    //     if ($error = $this->sendPermissionError('delete')) {
    //         return $error;
    //     }
    //     SalesInvoice::find($id)->delete();
    //     $invoice_no = $request->get('invoice_no');
    //     $customer_id = $request->get('customer_id');
    //     $invoices = SalesInvoice::select('amt')->where('invoice_no', $invoice_no)->where('customer_id', $customer_id)->get()->sum('amt');

    //     $ledgerBooks = SalesLedgerBook::where('invoice_no', $invoice_no)->where('customer_id', $customer_id)->get();

    //     foreach ($ledgerBooks as $ledgerBook) {
    //         $courier_pay = $ledgerBook->courier_pay;
    //         $payment = $ledgerBook->payment;
    //     }

    //     $ledgerUpdate = [
    //         'total_amt' =>$invoices,
    //         'dues_amt' =>$invoices - $courier_pay - $payment,
    //     ];
    //     SalesLedgerBook::where('invoice_no', $invoice_no)->where('customer_id', $customer_id)->update($ledgerUpdate);
    //     return redirect()->back();
    // }
}
