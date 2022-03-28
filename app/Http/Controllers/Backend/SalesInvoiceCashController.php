<?php

namespace App\Http\Controllers\Backend;

use App\Models\User;
use App\Models\Stock;
use App\Models\InvoiceDue;
use App\Models\SampleNote;
use App\Models\SalesReport;
use App\Models\ProductStock;
use App\Models\SalesInvoice;
use Illuminate\Http\Request;
use App\Models\SalesLedgerBook;
use App\Models\CompanyInfo;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use RealRashid\SweetAlert\Facades\Alert;

class SalesInvoiceCashController extends Controller
{
    public function index()
    {
        $customers = User::where('role', 2)->orderby('business_name', 'ASC')->get();
        $ceo = User::where('id', 10)->first();
        return view('admin.sales.sales_invoice_cash.index', compact('customers', 'ceo'));
    }

    public function createId($id)
    {
        if ($error = $this->sendPermissionError('create')) {
            return $error;
        }

        $customer = User::with(['customerInfo' => function ($q) {
            return $q->select('user_id', 'type', 'credit_limit');
        }])->select('id', 'name', 'business_name', 'address')->find($id);

        $userId = SalesReport::with(['userForSR' => function ($q) {
            return $q->select('id', 'tmm_so_id', 'name', 'role')->whereIn('role', ['1','5']);
        }])->distinct('user_id')->get(['user_id']);

        $invoice_no = SalesLedgerBook::select(['invoice_no','type'])->whereIn('type', [1,3,5])->count() + 697;
        $challan_no = SalesLedgerBook::select(['challan_no','type'])->whereIn('type', [1,3,5])->count() + 665;

        $ledgerPayment = SalesLedgerBook::where('customer_id', $id)->get(['net_amt','payment']);
        return view('admin.sales.sales_invoice_cash.create', compact('customer', 'invoice_no', 'userId', 'ledgerPayment', 'challan_no'));
    }

    public function dueInvoice(Request $request)
    {
        $inv_no = $request->inv_no;
        $products = DB::table('sales_ledger_books');
        $products->where('invoice_no', 'LIKE', '%'. $inv_no .'%');

        $products = $products->get();
        $subs = '';
        $subs .='<ul>';
        foreach ($products as $sub) {
            $subs .= '<li value="'.$sub->id.'">'.$sub->invoice_no.'</li>';
        }
        $subs .='</ul>';
        return $subs;
    }


    public function store(Request $request)
    {
        $this->validate($request, [
            'invoice_no' => 'required',
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

        DB::beginTransaction();

        $ledgerBookCheck = SalesLedgerBook::whereIn('type', [1,3])->where('invoice_no', $request->invoice_no)->get();
        if ($ledgerBookCheck->count() > 0) {
            alert()->error('ErrorAlert', 'Something went wrong! Please try again');
            return redirect()->back();
        } else {
            $invoiceArr = [];
            foreach ($request->product_id as $key => $v) {
                $data=[
                    'tran_id' => transaction_id('SEL'),
                    'user_id' => $user_id,
                    'customer_id' => $customer_id,
                    'product_id' => $request->product_id[$key],
                    'type' => $request->inv_type, // Cash
                    'invoice_no' => $invoice_no,
                    'challan_no' => $challan_no,
                    'size' => $request->size[$key],
                    'quantity' => $request->quantity[$key],
                    'bonus' => $request->bonus[$key],
                    'pro_dis' => $request->pro_dis[$key],
                    'rate_per_qty' => $request->rate_per_qty[$key],
                    'amt' => round($request->amt[$key]),
                    'invoice_date' => $request->invoice_date,
                ];
                $invoice = SalesInvoice::create($data);
                $invoiceArr[] = $invoice->id;
            };

            // Store Stock Start
            foreach ($request->quantity as $i => $qty) {
                $stok = ProductStock::where('product_id', $request->product_id[$i])->where('product_pack_size_id', $request->size[$i])->whereIn('type', [1,3])->first();
                $quantity   = $stok->quantity;
                $stockUpdate['quantity']    = $quantity - $qty - $request->bonus[$i];
                $stok->update($stockUpdate);
            }
            // New Stock
            foreach ($request->quantity as $key => $v) {
                $data=[
                    'tran_id' => transaction_id('SEL'),
                    'inv_id' => $invoiceArr[$key],
                    'product_id' => $request->product_id[$key],
                    'product_pack_size_id' => $request->size[$key],
                    'type' => $request->inv_type,
                    'stock_type' => 1, //Store
                    'challan_no' => $challan_no,
                    'quantity' => $request->quantity[$key],
                    'bonus' => $request->bonus[$key],
                    'amt' => round($request->amt[$key]) - round($request->amt[$key])*$request->pro_dis[$key]/100,
                    'dis' => $request->pro_dis[$key],
                    'net_amt' => round($request->amt[$key]),
                    'date' => $request->invoice_date,
                ];
                Stock::create($data);
            };
            // Store Stock End

            $ledgerBook = [
                'tran_id' => transaction_id('SEL'),
                'user_id' => $user_id,
                'customer_id' => $customer_id,
                'prepared_id' => auth()->user()->id,
                'type' => $request->inv_type,
                'invoice_no' => $invoice_no,
                'challan_no' => $challan_no,
                'sales_amt' => $request->get('total_amt'),
                'discount' => $request->get('discount'),
                'discount_amt' => $request->get('discount_amt'),
                'net_amt' => round($request->get('net_amt')),
                'payment' => round($request->get('payment')),
                'payment_date' =>  $request->payment_date,
                // 'user_type' =>  $request->get('user_type'),
                'invoice_date' => $request->invoice_date,
                'delivery_date' => $request->get('delivery_date'),
            ];

            $ledgerBook = SalesLedgerBook::create($ledgerBook);
            $salesReport = SalesReport::where('user_id', $request->user_id)->first();
            $productDiscount = array_sum($request->pro_dis) / count($invoiceArr);
            $report = [
                'tran_id' => transaction_id('SEL'),
                'user_id' => $salesReport->user_id,
                'type' => 1,
                'inv_type' => $request->inv_type,
                'sales_ledger_book_id' => $ledgerBook->id,
                'zsm_id' => $salesReport->zsm_id,
                'sso_id' => $salesReport->sso_id,
                'so_id' => $salesReport->so_id,
                'customer_id' => $customer_id,
                'invoice_date' => $request->invoice_date,
                'discount' => $request->discount + $productDiscount,
                'amt' => round($request->net_amt),
            ];
            SalesReport::create($report);

            if ($request->note) {
                $sampleNote = [
                    'sales_ledger_book_id' => $ledgerBook->id,
                    'note' => $request->note,
                    'tran_id' => transaction_id('SEL'),
                ];
                SampleNote::create($sampleNote);
            }

            if ($request->due == 1) {
                $this->validate($request, [
                    'inv_date' => 'required',
                    'inv_amt' => 'required',
                    'inv_payment' => 'required',
                    'inv_total' => 'required',
                ]);
                foreach ($request->inv_date as $key => $v) {
                    $invoiceDue=[
                        'tran_id' => transaction_id('SEL'),
                        'invoice_no' => $invoice_no,
                        'inv_date' => $request->inv_date[$key],
                        'inv_amt' => $request->inv_amt[$key],
                        'inv_payment' => $request->inv_payment[$key],
                        'inv_total' => $request->inv_total[$key],
                    ];
                    InvoiceDue::create($invoiceDue);
                };
            }


            try {
                if((CompanyInfo::whereId(1)->first('sms_service')->sms_service == 1) && (env('SMS_API') != "")){
                    $customerPhone = User::find($customer_id)->phone;
                    $am = round($request->net_amt);
                    $pD = bdDate($request->payment_date);
                    $msg = "Dear customer an Invoice has been created under your Account. Invoice no: ".$invoice_no.", Amount: ".$am."BDT. Last payment date: ".$pD.".";
                    sms($customerPhone, $msg);
                }
                DB::commit();
                toast('Sales Invoice Successfully Inserted', 'success');
                return redirect()->route('sales-invoice-cash.show', $customer_id);
            } catch (\Exception $ex) {
                return $ex->getMessage();
                DB::rollBack();
                toast('Sales Invoice Inserted Failed', 'error');
                return back();
            }
        }
    }

    public function show($id)
    {
        $customerInfo = SalesInvoice::with(['customer' => function ($q) {
            $q->select('id', 'business_name', 'name');
        }])->where('customer_id', $id)->first(['customer_id']);

        $getInvoice = SalesInvoice::where('customer_id', $id)->whereIn('type', [1,3])->latest()->get();
        $customerInvoices = $getInvoice->groupBy('invoice_no');
        if ($customerInfo == '') {
            alert()->info('Alert', 'There are no invoice. First create invoice');
            return redirect()->back();
        }
        return view('admin.sales.sales_invoice_cash.ind_invoice', compact('customerInvoices', 'customerInfo'));
    }

    //Edit invoice
    public function edit($user_id, $challan_no)
    {
        $customer = User::where('id', $user_id)->first();
        $userId = SalesReport::with(['userForSR' => function ($q) {
            return $q->select('id', 'tmm_so_id', 'name', 'role')->whereIn('role', ['1','5']);
        }])->distinct('user_id')->get(['user_id']);

        $ledger = SalesLedgerBook::where('customer_id', $user_id)->orderBy('id', 'DESC')->get();
        $ledgerPayment = SalesLedgerBook::where('customer_id', $user_id)->get();

        // for update
        $invoices = SalesInvoice::where('challan_no', $challan_no)->where('inv_cancel', 0)->get();
        $ledgerUpdate = SalesLedgerBook::where('customer_id', $user_id)->where('challan_no', $challan_no)->first();
        if ($ledgerUpdate->inv_cancel != 0) {
            alert()->info('Alert', 'The Invoice has already been canceled');
            return redirect()->back();
        }
        $invoice_no = SalesLedgerBook::select(['invoice_no','type'])->whereIn('type', [1,3,5])->count() + 697;
        $challan_no = SalesLedgerBook::select(['challan_no','type'])->whereIn('type', [1,3,5])->count() + 665;

        return view('admin.sales.sales_invoice_cash.edit', compact('invoices', 'customer', 'userId', 'ledgerPayment', 'ledger', 'ledgerUpdate', 'invoice_no', 'challan_no'));
    }

    public function update(Request $request)
    {
        // return $request->all;
        if ($error = $this->sendPermissionError('delete')) {
            return $error;
        }
        $this->validate($request, [
            'invoice_no' => 'required',
            'size' => 'required',
            'quantity' => 'required',
            'rate_per_qty' => 'required',
            'invoice_date' => 'required',
            'amt' => 'required',
        ]);


        $invoice_id = $request->invoice_id;
        $cancel_led_id = $request->cancel_led_id;
        $cancel_challan_no = $request->cancel_challan_no;

        $cancelInvoice = SalesInvoice::where('challan_no', $cancel_challan_no)->whereIn('type', [1,3])->update(['inv_cancel' => 2]);
        $cancelLedger = SalesLedgerBook::where('challan_no', $cancel_challan_no)->whereIn('type', [1,3])->update(['inv_cancel' => 2, 'sales_amt'=>0, 'discount'=>0, 'discount_amt'=>0, 'net_amt'=>0]);
        SalesReport::where('sales_ledger_book_id', $cancel_led_id)->delete() || '';

        $stock = Stock::whereIn('inv_id', $invoice_id)->whereIn('type', [1,3])->update(['inv_cancel' => 1]) || false;

        if ($request->cancel_note) {
            $cancelSampleNote = [
                'sales_ledger_book_id' => $cancel_led_id,
                'note' => $request->cancel_note
            ];
            SampleNote::where('sales_ledger_book_id', $cancel_led_id)->update($cancelSampleNote) || SampleNote::create($cancelSampleNote);
        }

        $customer_id = $request->get('customer_id');
        $invoice_no = $request->get('invoice_no');
        $challan_no = $request->get('challan_no');
        $user_id = $request->get('user_id');

        $ledgerBookCheck = SalesLedgerBook::whereIn('type', [1,3])->where('invoice_no', $request->invoice_no)->get();
        if ($ledgerBookCheck->count() > 0) {
            alert()->error('ErrorAlert', 'Something went wrong! Please try again');
            return redirect()->back();
        } else {
            DB::beginTransaction();
            $invoiceArr = [];
            foreach ($request->product_id as $key => $v) {
                $data=[
                    'user_id' => $user_id,
                    'customer_id' => $customer_id,
                    'product_id' => $request->product_id[$key],
                    'type' => $request->inv_type, // Cash
                    'invoice_no' => $invoice_no,
                    'challan_no' => $challan_no,
                    'size' => $request->size[$key],
                    'quantity' => $request->quantity[$key],
                    'bonus' => $request->bonus[$key],
                    'pro_dis' => $request->pro_dis[$key],
                    'rate_per_qty' => $request->rate_per_qty[$key],
                    // 'amt' => round($request->amt[$key]),
                    'amt' =>round(($request->quantity[$key] * $request->rate_per_qty[$key]) - (($request->quantity[$key] * $request->rate_per_qty[$key])*$request->pro_dis[$key]/100)),
                    'invoice_date' => $request->invoice_date,
                ];
                $invoice = SalesInvoice::create($data);
                $invoiceArr[] = $invoice->id;
            };

            // Store Stock Start
            foreach ($request->quantity as $i => $qty) {
                $stok = ProductStock::where('product_id', $request->product_id[$i])->where('product_pack_size_id', $request->size[$i])->whereIn('type', [1,3])->first();
                $quantity   = $stok->quantity;
                $stockUpdate['quantity']    = $quantity - $qty - $request->bonus[$i];
                $stok->update($stockUpdate);
            }
            // New Stock
            foreach ($request->quantity as $key => $v) {
                $data=[
                    'inv_id' => $invoiceArr[$key],
                    'product_id' => $request->product_id[$key],
                    'product_pack_size_id' => $request->size[$key],
                    'type' => $request->inv_type, // Cash
                    'stock_type' => 1, //Store
                    // 'inv_type' => $request->inv_type,
                    'challan_no' => $challan_no,
                    'quantity' => $request->quantity[$key],
                    'bonus' => $request->bonus[$key],
                    'amt' => round(($request->amt[$key]) - ($request->amt[$key] * $request->pro_dis[$key]/100)),
                    'dis' => $request->pro_dis[$key],
                    'net_amt' => round($request->amt[$key]),
                    'date' => $request->invoice_date,
                ];
                Stock::create($data);
            };
            // Store Stock End

            $discount = array_sum($request->get('amt')) * $request->get('discount')/100;

            $ledgerBook = [
                'user_id' => $user_id,
                'customer_id' => $customer_id,
                'prepared_id' => auth()->user()->id,
                'type' => $request->inv_type, // Cash
                'invoice_no' => $invoice_no,
                'challan_no' => $challan_no,
                'sales_amt' => array_sum($request->get('amt')),
                'discount' => $request->get('discount'),
                'net_amt' => round(array_sum($request->get('amt')) - $discount),
                'payment' => round($request->get('payment')),
                'payment_date' =>  $request->get('payment_date'),
                // 'user_type' =>  $request->get('user_type'),
                'invoice_date' => $request->invoice_date,
                'delivery_date' => $request->get('delivery_date'),
            ];
            $ledgerBook = SalesLedgerBook::create($ledgerBook);

            $salesReport = SalesReport::where('user_id', $request->user_id)->first();
            $report = [
                'user_id' => $salesReport->user_id,
                'type' => 1,
                'inv_type' => $request->inv_type,
                'sales_ledger_book_id' => $ledgerBook->id,
                'zsm_id' => $salesReport->zsm_id,
                'sso_id' => $salesReport->sso_id,
                'so_id' => $salesReport->so_id,
                'customer_id' => $customer_id,
                'invoice_date' => $request->invoice_date,
                'amt' => round(array_sum($request->get('amt')) - $discount),
            ];
            SalesReport::create($report);

            if ($request->note) {
                $sampleNote = [
                    'sales_ledger_book_id' => $ledgerBook->id,
                    'note' => $request->note
                ];
                SampleNote::create($sampleNote);
            }


            if ($request->due == 1) {
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

            try {
                DB::commit();
                toast('Sales Invoice Successfully Inserted', 'success');
                return redirect()->route('sales-invoice-cash.show', $customer_id);
            } catch (\Exception $ex) {
                DB::rollBack();
                toast($ex->getMessage().'Sales Invoice Inserted Faild', 'error');
                return back();
            }
        }
    }

    public function cancelInv($challan_no)
    {
        if ($error = $this->sendPermissionError('delete')) {
            return $error;
        }
        $invoice_id = SalesInvoice::where('challan_no', $challan_no)->whereIn('type', [1,3])->get()->pluck('id');
        $cancelInvoice = SalesInvoice::where('challan_no', $challan_no)->whereIn('type', [1,3]);
        if ($cancelInvoice->first()->inv_cancel != 0) {
            Alert::info('The Invoice has already been canceled');
            return redirect()->back();
        }
        SalesInvoice::whereIn('id', $invoice_id)->update(['inv_cancel' => 1]);
        $cancelLedger = SalesLedgerBook::where('challan_no', $challan_no)->whereIn('type', [1,3]);
        $cancel_led_id = $cancelLedger->first()->id;
        $cancelLedger->update(['inv_cancel' => 1, 'sales_amt'=>0, 'discount'=>0, 'discount_amt'=>0, 'net_amt'=>0]);
        SalesReport::where('sales_ledger_book_id', $cancel_led_id)->delete() || false;
        Stock::whereIn('inv_id', $invoice_id)->whereIn('type', [1,3])->update(['inv_cancel' => 1]) || false;

        toast('success', 'success');
        return redirect()->back();
    }

    public function delete($invoice_id, $challan_no)
    {
        if ($error = $this->sendPermissionError('delete')) {
            return $error;
        }
        $invoiceCheck = SalesInvoice::where('challan_no', $challan_no)->where('inv_cancel', 0)->whereIn('type', [1,3])->get();
        if ($invoiceCheck->count() < 2) {
            Alert::info('Alert', 'Must have at least one data');
            return redirect()->back();
        }
        $invoice = SalesInvoice::where('id', $invoice_id)->whereIn('type', [1,3])->first();
        $invData['inv_cancel'] = 1;

        $stock = Stock::where('inv_id', $invoice_id)->whereIn('type', [1,3])->first();
        if ($stock) {
            $stock->update(['inv_cancel' => 1]);
        }
        $invoice->update($invData);

        toast('success', 'success');
        return redirect()->back();
    }

    // ind show
    public function showInvoice($customer_id, $invoice_no)
    {
        $showInvoices = SalesInvoice::where('customer_id', $customer_id)->where('invoice_no', $invoice_no)->whereIn('type', [1,3])->get();
        $customerInfo = SalesInvoice::where('invoice_no', $invoice_no)->where('customer_id', $customer_id)->whereIn('type', [1,3])->first();
        $total_amt = SalesLedgerBook::where('invoice_no', $invoice_no)->whereIn('type', [1,3])->first();
        return view('admin.sales.sales_invoice_cash.show_invoice', compact('showInvoices', 'customerInfo', 'total_amt'));
    }

    // All invoice
    public function allInvoice()
    {
        $getChallan = SalesInvoice::whereIn('type', [1,3])->latest()->get();
        $supplierChallans = $getChallan->groupBy('invoice_no');
        return view('admin.sales.sales_invoice_cash.all_invoice', compact('supplierChallans'));
    }

    public function allInvoiceShow($invoice_no)
    {
        $showInvoices = SalesInvoice::where('invoice_no', $invoice_no)->whereIn('type', [1,3])->get(); // 1 = Sales of Cash
        $supplierInfo = SalesInvoice::whereIn('type', [1,3])->first();
        return view('admin.sales.sales_invoice_cash.all_invoice_show', compact('showInvoices', 'supplierInfo'));
    }

    // All by date
    public function selectDate()
    {
        return view('admin.sales.sales_invoice_cash.select_date');
    }

    public function allInvoiceByDate(Request $request)
    {
        $form_date = $request->get('form_date');
        $to_date = $request->get('to_date');

        $getChallan = SalesInvoice::whereBetween('invoice_date', [$form_date,$to_date])->whereIn('type', [1,3])->latest()->get();
        $supplierChallans = $getChallan->groupBy('invoice_no');
        return view('admin.sales.sales_invoice_cash.all_invoice_by_date', compact('supplierChallans'));
    }

    public function allInvoiceShowByDate($invoice_no)
    {
        $showInvoices = SalesInvoice::where('invoice_no', $invoice_no)->whereIn('type', [1,3])->get(); // 1 = Sales of Cash
        $customerInfo = SalesInvoice::where('type', 7)->first();
        return view('admin.sales.sales_invoice_cash.all_invoice_show_by_date', compact('showInvoices', 'customerInfo'));
    }

    public function printInvoice($customer_id, $invoice_no)
    {
        $getShowInvoices = SalesInvoice::where('customer_id', $customer_id)->where('invoice_no', $invoice_no)->whereIn('type', [1,3])->get();
        $showInvoices = $getShowInvoices->groupby('product_id');

        $invoiceDue = InvoiceDue::where('invoice_no', $invoice_no)->get();
        $invoiceDueFirst = InvoiceDue::where('invoice_no', $invoice_no)->first();
        $ledger = SalesLedgerBook::where('invoice_no', $invoice_no)->whereIn('type', [1,3])->first();
        return view('admin.sales.sales_invoice_cash.print_invoice', compact('showInvoices', 'invoiceDue', 'ledger', 'invoiceDueFirst', 'getShowInvoices'));
    }

    public function printChallan($customer_id, $invoice_no)
    {
        $getShowInvoices = SalesInvoice::where('customer_id', $customer_id)->where('invoice_no', $invoice_no)->whereIn('type', [1,3])->get();
        $showInvoices = $getShowInvoices->groupby('product_id');

        $invoiceDue = InvoiceDue::where('invoice_no', $invoice_no)->get();
        $invoiceDueFirst = InvoiceDue::where('invoice_no', $invoice_no)->first();
        $ledger = SalesLedgerBook::where('invoice_no', $invoice_no)->whereIn('type', [1,3])->first();
        return view('admin.sales.sales_invoice_cash.print_challan', compact('showInvoices', 'invoiceDue', 'ledger', 'invoiceDueFirst'));
    }
}
