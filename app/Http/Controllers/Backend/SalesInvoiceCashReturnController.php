<?php

namespace App\Http\Controllers\Backend;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Stock;
use App\Models\IsReturn;
use App\Models\InvoiceDue;
use App\Models\SalesReport;
use App\Models\ProductStock;
use App\Models\SalesInvoice;
use Illuminate\Http\Request;
use App\Models\SalesLedgerBook;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class SalesInvoiceCashReturnController extends Controller
{
    public function index()
    {
        $customers = User::where('role',2)->orderby('business_name','ASC')->get();
        return view('admin.sales.sales_invoice_cash_return.index', compact('customers'));
    }

    public function createId($id)
    {
        if ($error = $this->sendPermissionError('create')) {
            return $error;
        }

        $customer = User::with(['customerInfo' => function($q){
            return $q->select('user_id','type','credit_limit');
        }])->select('id','name','business_name','address')->find($id);

        $userId = SalesReport::with(['userForSR' => function($q){
            return $q->select('id','tmm_so_id','name','role')->whereIn('role',['1','5']);
        }])->distinct('user_id')->get(['user_id']);

        $invoice_no = SalesLedgerBook::select(['invoice_no','type'])->whereIn('type', [2,4])->count() + 33;
        $challan_no = SalesLedgerBook::select(['challan_no','type'])->whereIn('type', [2,4])->count() + 33;

        $ledger = SalesLedgerBook::where('customer_id',$id)->orderBy('id','DESC')->get(['net_amt']);
        $ledgerPayment = SalesLedgerBook::where('customer_id', $id)->first();
        return view('admin.sales.sales_invoice_cash_return.create', compact('customer','invoice_no','userId','ledger','ledgerPayment','challan_no'));
    }


    public function store(Request $request)
    {
       $this->validate($request,[
            'invoice_no' => 'required',
            'challan_no' => 'required',
            'size' => 'required',
            'quantity' => 'required',
            'rate_per_qty' => 'required',
            'invoice_date' => 'required',
            'amt' => 'required',
            'r_type' => 'required',
        ]);

        DB::beginTransaction();

        $customer_id = $request->get('customer_id');
        $invoice_no = $request->get('store_invoice_no');
        $challan_no = $request->get('challan_no');
        $user_id = $request->get('user_id');
        $r_type = $request->get('r_type');
        $transaction_id = transaction_id('SER');



        $invoiceArr = [];
        foreach($request->product_id as $key => $v){
            $data=[
                'tran_id' => $transaction_id,
                'user_id' => $user_id,
                'customer_id' => $customer_id,
                'product_id' => $request->product_id[$key],
                'type' => $request->inv_type, // Cash
                'r_type' => $r_type,
                'invoice_no' => $invoice_no,
                'challan_no' => $challan_no,
                'size' => $request->size[$key],
                'quantity' => $request->quantity[$key],
                'bonus' => $request->bonus[$key],
                'pro_dis' => $request->pro_dis[$key],
                'rate_per_qty' => $request->rate_per_qty[$key],
                // 'discount' => $request->discount[$key],
                'amt' => '-'.$request->amt[$key],
                'invoice_date' => $request->invoice_date,
            ];
            $invoice = SalesInvoice::create($data);
            $invoiceArr[] = $invoice->id;
        };

        foreach($request->inv_id as $key => $v){
            $isReturn=[
                'tran_id' => $transaction_id,
                'sales_invoice_id' => $request->inv_id[$key],
                'product_id' => $request->product_id[$key],
                'product_pack_size_id' => $request->size[$key],
                'invoice_no' => $invoice_no,
            ];
            IsReturn::create($isReturn);
        };

        // New Stock
        foreach ($request->quantity as $key => $v) {
            $data=[
                'tran_id' => $transaction_id,
                'inv_id' => $invoiceArr[$key],
                'product_id' => $request->product_id[$key],
                'product_pack_size_id' => $request->size[$key],
                // 'type' => $request->inv_type,
                'type' => $r_type,
                'stock_type' => 1, //Store
                'challan_no' => $challan_no,
                'quantity' => $request->quantity[$key],
                'bonus' => $request->bonus[$key],
                'amt' => round('-'.$request->amt[$key]) - round($request->amt[$key])*$request->pro_dis[$key]/100,
                'dis' => $request->pro_dis[$key],
                'net_amt' => round('-'.$request->amt[$key]),
                'date' => $request->invoice_date,
            ];
            Stock::create($data);
        };
        // Store Stock End

        $ledgerBook = [
            'tran_id' => $transaction_id,
            'user_id' => $user_id,
            'customer_id' => $customer_id,
            'prepared_id' => auth()->user()->id,
            'type' => $request->inv_type, // Cash
            'r_type' => $r_type,
            'invoice_no' => $invoice_no,
            'challan_no' => $challan_no,
            'sales_amt' => '-'.$request->get('total_amt'),
            'discount' => $request->get('discount'),
            'discount_amt' => $request->get('discount_amt'),
            'net_amt' => round('-'.$request->get('net_amt')),
            // 'payment' => round($request->get('payment')),
            // 'payment_date' =>  $request->get('payment_date'),
            // 'user_type' =>  $request->get('user_type'),
            'invoice_date' => $request->invoice_date,
            // 'delivery_date' => $request->get('delivery_date'),
        ];

        $salesReport = SalesReport::where('user_id', $request->user_id)->first();
        $report = [
            'tran_id' => $transaction_id,
            'user_id' => $salesReport->user_id,
            'type' => 1, // return
            'inv_type' => $request->inv_type,
            'zsm_id' => $salesReport->zsm_id,
            'sso_id' => $salesReport->sso_id,
            'so_id' => $salesReport->so_id,
            'customer_id' => $customer_id,
            'invoice_date' => $request->invoice_date,
            'amt' => '-'.$request->net_amt,
        ];
        SalesReport::create($report);

        try {
            $ledgerBook = SalesLedgerBook::create($ledgerBook);
            DB::commit();
            toast('Sales Return Invoice Successfully Inserted','success');
            return redirect()->route('sales-invoice-cash-return.index');
        } catch (\Exception $ex) {
            DB::rollBack();
            toast($ex->getMessage().'Sales Return Invoice Inserted Faild','error');
            return back();
        }
    }


    public function show($id)
    {
        $customerInfo = SalesInvoice::where('customer_id', $id)->first();
        $getInvoice = SalesInvoice::where('customer_id', $id)->whereIn('type', [2,4])->latest()->get();
        $customerInvoices = $getInvoice->groupBy('invoice_no');
        if($customerInfo == ''){
            alert()->info('Alert','There are no invoice. First create invoice');
            return redirect()->back();
        }
        return view('admin.sales.sales_invoice_cash_return.ind_invoice', compact('customerInvoices','customerInfo'));
    }

    // ind show
    public function showInvoice($customer_id, $invoice_no)
    {
        $showInvoices = SalesInvoice::where('customer_id', $customer_id)->where('invoice_no', $invoice_no)->whereIn('type', [2,4])->get();
        $customerInfo = SalesInvoice::where('invoice_no', $invoice_no)->where('customer_id', $customer_id)->whereIn('type', [2,4])->first();
        $total_amt = SalesLedgerBook::where('invoice_no', $invoice_no)->whereIn('type', [2,4])->first();
        return view('admin.sales.sales_invoice_cash_return.show_invoice', compact('showInvoices','customerInfo','total_amt'));
    }

    // All invoice
    public function allInvoice()
    {
        $getChallan = SalesInvoice::whereIn('type', [2,4])->latest()->get();
        $supplierChallans = $getChallan->groupBy('invoice_no');
        return view('admin.sales.sales_invoice_cash_return.all_invoice', compact('supplierChallans'));
    }

    public function allInvoiceShow($invoice_no)
    {
        $showInvoices = SalesInvoice::where('invoice_no', $invoice_no)->whereIn('type', [2,4])->get(); // 1 = Sales of Cash Return
        $supplierInfo = SalesInvoice::whereIn('type', [2,4])->first();
        return view('admin.sales.sales_invoice_cash_return.all_invoice_show', compact('showInvoices','supplierInfo'));
    }

    // All by date
    public function selectDate()
    {
        return view('admin.sales.sales_invoice_cash_return.select_date');
    }

    public function allInvoiceByDate(Request $request)
    {
        $form_date = $request->get('form_date');
        $to_date = $request->get('to_date');

        $getChallan = SalesInvoice::whereBetween('invoice_date',[$form_date,$to_date])->whereIn('type', [2,4])->latest()->get();
        $supplierChallans = $getChallan->groupBy('invoice_no');
        return view('admin.sales.sales_invoice_cash_return.all_invoice_by_date', compact('supplierChallans'));
    }

    public function allInvoiceShowByDate($invoice_no)
    {
        $showInvoices = SalesInvoice::where('invoice_no', $invoice_no)->whereIn('type', [2,4])->get(); // 1 = Sales of Cash
        $customerInfo = SalesInvoice::where('type', 7)->first();
        return view('admin.sales.sales_invoice_cash_return.all_invoice_show_by_date', compact('showInvoices','customerInfo'));
    }

    public function printInvoice($customer_id, $invoice_no)
    {
        $getShowInvoices = SalesInvoice::with(['isReturnInvC'])->where('customer_id', $customer_id)->where('invoice_no', $invoice_no)->whereIn('type', [2,4])->get();
        $showInvoices = $getShowInvoices->groupBy('product_id');

        $invoiceDue = InvoiceDue::where('invoice_no',$invoice_no)->get();
        $invoiceDueFirst = InvoiceDue::where('invoice_no',$invoice_no)->first();
        $ledger = SalesLedgerBook::with(['customer','tmmSoId','preparedBy'])->where('invoice_no', $invoice_no)->first();
        return view('admin.sales.sales_invoice_cash_return.print_invoice', compact('showInvoices','invoiceDue','ledger','invoiceDueFirst','getShowInvoices'));
    }

    public function printChallan($customer_id, $invoice_no)
    {
        $getShowInvoices = SalesInvoice::with(['isReturnInvC'])->where('customer_id', $customer_id)->where('invoice_no', $invoice_no)->whereIn('type', [2,4])->get();
        $showInvoices = $getShowInvoices->groupBy('product_id');

        $invoiceDue = InvoiceDue::where('invoice_no',$invoice_no)->get();
        $invoiceDueFirst = InvoiceDue::where('invoice_no',$invoice_no)->first();
        $ledger = SalesLedgerBook::with(['customer','tmmSoId','preparedBy'])->where('invoice_no', $invoice_no)->first();
        return view('admin.sales.sales_invoice_cash_return.print_challan', compact('showInvoices','invoiceDue','ledger','invoiceDueFirst'));
    }

     // Soft Delete
    public function destroyInvoice($invoice_no)
    {
        if ($error = $this->sendPermissionError('delete')) {
            return $error;
        }
        SalesInvoice::where('invoice_no',$invoice_no)->delete();
        SalesLedgerBook::where('invoice_no',$invoice_no)->delete();
        if(SalesInvoice::count() < 1){
            toast('Sales Invoice Successfully Deleted','success');
            return redirect()->route('invoice.index');
        }else{
            toast('Sales Invoice Successfully Deleted','success');
            return redirect()->back();
        }
    }
    // public function index()
    // {
    //     $customers = User::where('role', 2)->get();
    //     return view('admin.sales.sales_invoice_cash_return_return.index', compact('customers'));
    // }

    // public function createId($id)
    // {
    //     $customer = User::find($id);
    //     $getInvoice_no = SalesInvoice::select(['invoice_no','type'])->withTrashed()->where('type', 2)->orwhere('type', 4)->get();
    //     $invoice_no = $getInvoice_no->groupBy('invoice_no')->count() + 101;
    //     return view('admin.sales.sales_invoice_cash_return_return.create', compact('customer','invoice_no'));
    // }

    // public function store(Request $request)
    // {
    //     $this->validate($request,[
    //         'invoice_no' => 'required',
    //         'size' => 'required',
    //         'quantity' => 'required',
    //         'rate_per_qty' => 'required',
    //         'amt' => 'required',
    //         'invoice_date' => 'required',
    //     ]);

    //     $customer_id = $request->get('customer_id');
    //     $invoice_no = $request->get('invoice_no');
    //     $invoice_date = $request->get('invoice_date');
    //     // $payment_date = $request->get('payment_date');

    //     DB::beginTransaction();

    //     // Invoice
    //     foreach($request->product_id as $key => $v){
    //         $data=[
    //             'customer_id' => $customer_id,
    //             'product_id' => $request->product_id[$key],
    //             'type' => 2,
    //             'invoice_no' => $invoice_no,
    //             'size' => $request->size[$key],
    //             'quantity' => $request->quantity[$key],
    //             'rate_per_qty' => $request->rate_per_qty[$key],
    //             'discount' => $request->discount[$key],
    //             'amt' => $request->amt[$key],
    //             'invoice_date' => $invoice_date,
    //             // 'payment_date' => $payment_date,
    //         ];
    //         $invoice = SalesInvoice::create($data);
    //     }

    //     // Stock
    //     $stocks = ProductStock::whereIn('product_id', $request->product_id)->whereIn('product_pack_size_id', $request->size)->get();
    //     foreach($stocks as $i=>$stok){
    //         $quantity = $stok->quantity;
    //         $stockUpdate['quantity'] = $quantity + $request->quantity[$i];

    //         ProductStock::where('product_id', $request->product_id[$i])->where('product_pack_size_id', $request->size[$i])->first()->update($stockUpdate);
    //     }

    //     // ledger Book
    //     $ledgerBook = [
    //         'customer_id' => $customer_id,
    //         'type' => 2,
    //         'invoice_no' => $invoice_no,
    //         'invoice_date' => $invoice_date,
    //         'sales_amt' => '-'.$request->get('total_amt'),
    //     ];

    //     try {
    //         $ledgerBook = SalesLedgerBook::create($ledgerBook);
    //         $invoice == true;
    //         DB::commit();
    //         toast('invoice Successfully Inserted','success');
    //         return redirect()->route('sales-invoice-cash-return.index');

    //     } catch (\Exception $ex) {
    //         DB::rollBack();
    //         toast($ex->getMessage().'invoice Inserted Faild','error');
    //         return back();
    //     }
    // }

    // public function show($id)
    // {
    //     $customerInfo = SalesInvoice::where('customer_id', $id)->first();
    //     $getInvoice = SalesInvoice::where('customer_id', $id)->where('type', 2)->latest()->get();
    //     $customerInvoices = $getInvoice->groupBy('invoice_no');
    //     if($getInvoice->count() < 1){
    //         alert()->info('Alert','There are no invoice. First create invoice');
    //         return redirect()->back();
    //     }
    //    return view('admin.sales.sales_invoice_cash_return_return.customer_invoice', compact('customerInvoices','customerInfo'));
    // }

    // public function showInvoice($customer_id, $invoice_no)
    // {
    //     $showInvoices = SalesInvoice::where('customer_id', $customer_id)->where('invoice_no', $invoice_no)->whereIn('type', [2,4])->get();
    //     $customerInfo = SalesInvoice::where('customer_id', $customer_id)->first();
    //     return view('admin.sales.sales_invoice_cash_return_return.show_invoice', compact('showInvoices','customerInfo'));
    // }

    // public function destroyInvoice($invoice_no)
    // {
    //     SalesInvoice::where('invoice_no', $invoice_no)->delete();
    //     SalesLedgerBook::where('invoice_no',$invoice_no)->delete();
    //     if(SalesInvoice::where('type', 2)->count() < 1){
    //         toast('Invoice Successfully Deleted','success');
    //         return redirect()->route('return-sales-invoice.index');
    //     }else{
    //         toast('Invoice Successfully Deleted','success');
    //         return redirect()->back();
    //     }
    // }

    // public function destroy(Request $request, $id)
    // {
    //     SalesInvoice::find($id)->delete();
    //     $amt = 0;
    //     $invoice_no = $request->get('invoice_no');
    //     $customer_id = $request->get('customer_id');
    //     $invoices = SalesInvoice::select('amt')->where('invoice_no', $invoice_no)->where('customer_id', $customer_id)->get()->sum('amt');

    //     $ledgerBooks = SalesLedgerBook::where('invoice_no', $invoice_no)->where('customer_id', $customer_id)->get();

    //     foreach($ledgerBooks as $ledgerBook)
    //     {
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
