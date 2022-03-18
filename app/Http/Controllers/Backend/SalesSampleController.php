<?php

namespace App\Http\Controllers\Backend;

use App\Models\User;
use App\Models\Stock;
use App\Models\SampleNote;
use App\Models\SalesReport;
use App\Models\ProductStock;
use App\Models\SalesInvoice;
use Illuminate\Http\Request;
use App\Models\SalesLedgerBook;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class SalesSampleController extends Controller
{
    public function index()
    {
        $customers = User::where('id', 10)->get();
        return view('admin.sales.sample.index', compact('customers'));
    }

    public function createId($id)
    {
        if ($error = $this->sendPermissionError('create')) {
            return $error;
        }

        $customer = User::find($id);
        $getUserId = SalesReport::select(['id','user_id'])->get();
        $userId = $getUserId->groupby('user_id');
        $invoice_no = SalesLedgerBook::select(['invoice_no','type'])->where('type', 1)->orwhere('type', 3)->orwhere('type', 5)->count() + 697;

        $challan_no = SalesLedgerBook::select(['challan_no','type'])->where('type', 1)->orwhere('type', 3)->orwhere('type', 5)->count() + 665;

        $ledger = SalesLedgerBook::where('customer_id',$id)->orderBy('id','DESC')->get();
        $ledgerPayment = SalesLedgerBook::where('customer_id', $id)->get();
        return view('admin.sales.sample.create', compact('customer','invoice_no','userId','ledger','ledgerPayment','challan_no'));
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            // 'invoice_no' => 'required',
            'size' => 'required',
            'quantity' => 'required',
            'rate_per_qty' => 'required',
            'invoice_date' => 'required',
            'amt' => 'required',
        ]);


        $customer_id = $request->get('customer_id');
        $invoice_no = $request->get('invoice_no');
        $challan_no = $request->get('challan_no');
        $user_id = $request->get('user_id');
        $transaction_id = transaction_id('SSM');


        $ledgerBookCheck = SalesLedgerBook::where('type', 5)->where('invoice_no', $request->invoice_no)->get();
        if($ledgerBookCheck->count() > 0){
            alert()->error('ErrorAlert','Something went wrong! Please try again');
            return redirect()->back();
        }else{
            DB::beginTransaction();
            foreach($request->product_id as $key => $v){
                $data=[
                    'tran_id' => $transaction_id,
                    'user_id' => 10,
                    'customer_id' => $customer_id,
                    'product_id' => $request->product_id[$key],
                    'type' => 5, // Sample
                    'invoice_no' => $invoice_no, // Sample
                    'challan_no' => $challan_no,
                    'size' => $request->size[$key],
                    'quantity' => $request->quantity[$key],
                    'rate_per_qty' => $request->rate_per_qty[$key],
                    'amt' => $request->amt[$key],
                    'invoice_date' => $request->invoice_date,
                ];
                $invoice = SalesInvoice::create($data);
            };

            // Store Stock Start
            // foreach($request->quantity as $i => $qty){
            //     $stok = ProductStock::where('product_id', $request->product_id[$i])->where('product_pack_size_id', $request->size[$i])->where('type', 1)->first();
            //     $quantity   = $stok->quantity;
            //     $stockUpdate['quantity']    = $quantity - $qty;
            //     $stok->update($stockUpdate);
            // }

            // New Stock
            foreach ($request->product_id as $key => $v) {
                $data=[
                    'tran_id' => $transaction_id,
                    'inv_id' => $invoice->id,
                    'product_id' => $request->product_id[$key],
                    'product_pack_size_id' => $request->size[$key],
                    'type' => 5, // Sample
                    'stock_type' => 1, // Store
                    'challan_no' => $challan_no,
                    'quantity' => $request->quantity[$key],
                    // 'bonus' => $request->bonus[$key],
                    // 'amt' => round($request->amt[$key]) - round($request->amt[$key])*$request->pro_dis[$key]/100,
                    // 'dis' => $request->pro_dis[$key],
                    'net_amt' => round($request->amt[$key]),
                    'date' => $request->invoice_date,
                ];
                Stock::create($data);
            };
            // Store Stock End

            $ledgerBook = [
                'tran_id' => $transaction_id,
                'user_id' => 10,
                'customer_id' => $customer_id,
                'prepared_id' => auth()->user()->id,
                'type' => 5, // Sample
                'invoice_no' => $invoice_no, // Sample
                'challan_no' => $challan_no,
                'sales_amt' => $request->get('total_amt'),
                'discount' => $request->get('discount'),
                'discount_amt' => $request->get('discount_amt'),
                'net_amt' => $request->get('total_amt'),
                'payment' => $request->get('payment'),
                'payment_date' =>  $request->get('payment_date'),
                // 'user_type' =>  $request->get('user_type'),
                'invoice_date' => $request->invoice_date,
                'delivery_date' => $request->get('delivery_date'),
            ];
            $ledgerBook = SalesLedgerBook::create($ledgerBook);

            $sampleNote = [
                'tran_id' => $transaction_id,
                'sales_ledger_book_id' => $ledgerBook->id,
                'note' => $request->note
            ];
            SampleNote::create($sampleNote);

            // $salesReport = SalesReport::where('user_id', $request->user_id)->first();
            // $report = [
            //     'user_id' => $salesReport->user_id,
            //     'type' => 1,
            //     'inv_type' => 1,
            //     'zsm_id' => $salesReport->zsm_id,
            //     'sso_id' => $salesReport->sso_id,
            //     'so_id' => $salesReport->so_id,
            //     'customer_id' => $customer_id,
            //     'invoice_date' => $request->invoice_date,
            //     'amt' => $request->net_amt,
            // ];
            // SalesReport::create($report);

            try {
                // $ledgerBook = SalesLedgerBook::create($ledgerBook);
                $invoice == true;
                DB::commit();
                toast('Invoice Successfully Inserted','success');
                return redirect()->route('sample-invoive.index');
            } catch (\Exception $ex) {
                DB::rollBack();
                toast($ex->getMessage().'Invoice Inserted Faild','error');
                return back();
            }
        }
    }

    public function show($id)
    {
        $customerInfo = SalesInvoice::where('customer_id', $id)->first();
        $getInvoice = SalesInvoice::where('customer_id', $id)->where('type', 5)->latest()->get();
        $customerInvoices = $getInvoice->groupBy('invoice_no');
        if($customerInfo == ''){
            alert()->info('Alert','There are no invoice. First create invoice');
            return redirect()->back();
        }
        return view('admin.sales.sample.customer_invoice', compact('customerInvoices','customerInfo'));
    }

    public function showInvoice($customer_id, $invoice_no)
    {
        $showInvoices = SalesInvoice::where('customer_id', $customer_id)->where('invoice_no', $invoice_no)->where('type', 6)->get();
        $customerInfo = SalesInvoice::where('customer_id', $customer_id)->first();
        return view('admin.sales.sample.show_invoice', compact('showInvoices','customerInfo'));
    }

    public function printInvoice($customer_id, $invoice_no)
    {
        $getShowInvoices = SalesInvoice::where('customer_id', $customer_id)->where('invoice_no', $invoice_no)->where('type', 5)->get();
        $showInvoices = $getShowInvoices->groupby('product_id');

        // $invoiceDue = InvoiceDue::where('invoice_no',$invoice_no)->get();
        // $invoiceDueFirst = InvoiceDue::where('invoice_no',$invoice_no)->first();
        $ledger = SalesLedgerBook::where('invoice_no', $invoice_no)->first();
        return view('admin.sales.sample.print_invoice', compact('showInvoices','ledger','getShowInvoices'));
    }

    public function printChallan($customer_id, $invoice_no)
    {
        $getShowInvoices = SalesInvoice::where('customer_id', $customer_id)->where('invoice_no', $invoice_no)->where('type', 5)->get();
        $showInvoices = $getShowInvoices->groupby('product_id');

        // $invoiceDue = InvoiceDue::where('invoice_no',$invoice_no)->get();
        // $invoiceDueFirst = InvoiceDue::where('invoice_no',$invoice_no)->first();
        $ledger = SalesLedgerBook::where('invoice_no', $invoice_no)->first();
        return view('admin.sales.sample.print_challan', compact('showInvoices','ledger'));
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
            return redirect()->route('sample-invoice.index');
        }else{
            toast('Sales Invoice Successfully Deleted','success');
            return redirect()->back();
        }
    }
}
