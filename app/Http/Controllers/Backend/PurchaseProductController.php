<?php

namespace App\Http\Controllers\Backend;

use App\Models\User;
use App\Models\Stock;
use App\Models\SampleNote;
use Illuminate\Http\Request;
use App\Models\PurchaseInvoice;
use App\Models\PurchaseLedgerBook;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class PurchaseProductController extends Controller
{
    public function index()
    {
        // if ($error = $this->authorize('sales-sales-manage')) {
        //     return $error;
        // }
        $suppliers = User::where('role', 3)->orderby('name')->get();
        return view('admin.purchase.product.index', compact('suppliers'));
    }

    public function createId($id)
    {
        if ($error = $this->authorize('sales-sales-sales')) {
            return $error;
        }
        $supplier = User::select('id', 'name', 'address')->find($id);
        $userId = User::select(['id','tmm_so_id','role','name'])->whereIn('role', [1,5])->whereNot('name','Developer')->get();
        $invoice_no = PurchaseLedgerBook::select(['invoice_no','type'])->whereIn('type', [30, 31])->count() + 1;
        $challan_no = PurchaseLedgerBook::select(['challan_no','type'])->whereIn('type', [30, 31])->count() + 1;
        $ledgerPayment = PurchaseLedgerBook::where('supplier_id', $id)->get(['net_amt','payment']);
        return view('admin.purchase.product.create', compact('supplier', 'ledgerPayment', 'invoice_no', 'challan_no','userId'));
    }

    // public function dueInvoice(Request $request)
    // {
    //     $products = PurchaseLedgerBook::whereSupplier_id($request->supplier_id)->where('c_status','!=',1)->whereInv_cancel(0)->where('invoice_no', 'LIKE', '%'. $request->inv_no .'%');

    //     $products = $products->get();
    //     $subs = '';
    //     $subs .='<ul>';
    //     foreach ($products as $sub) {
    //         $subs .= '<li value="'.$sub->id.'">'.$sub->invoice_no.'</li>';
    //     }
    //     $subs .='</ul>';
    //     return $subs;
    // }


    public function store(Request $request)
    {
        if ($error = $this->authorize('sales-sales-sales')) {
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

        $supplier_id = $request->get('supplier_id');
        $invoice_no = $request->get('invoice_no');
        $challan_no = $request->get('challan_no');
        $user_id = $request->get('user_id');
        $transaction_id = transaction_id('PPU');

        DB::beginTransaction();

        $ledgerBookCheck = PurchaseLedgerBook::whereIn('type', [1,3])->where('invoice_no', $request->invoice_no)->get();
        if ($ledgerBookCheck->count() > 0) {
            alert()->error('Error Alert', 'Something went wrong! Please try again');
            return redirect()->back();
        } else {
            $invoiceArr = [];
            foreach ($request->product_id as $key => $v) {
                $data=[
                    'tran_id' => $transaction_id,
                    'user_id' => $user_id,
                    'supplier_id' => $supplier_id,
                    'product_id' => $request->product_id[$key],
                    'type' => 30, // Cash
                    'status' => 1, // Not sure
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
                $invoice = PurchaseInvoice::create($data);
                $invoiceArr[] = $invoice->id;
            };

            // New Stock
            foreach ($request->quantity as $key => $v) {
                $data=[
                    'tran_id' => $transaction_id,
                    'inv_id' => $invoiceArr[$key],
                    'product_id' => $request->product_id[$key],
                    'product_pack_size_id' => $request->size[$key],
                    'type' => 30,
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
                'tran_id' => $transaction_id,
                'user_id' => $user_id,
                'supplier_id' => $supplier_id,
                'prepared_id' => auth()->user()->id,
                'type' => 30,
                'invoice_no' => $invoice_no,
                'challan_no' => $challan_no,
                'purchase_amt' => $request->get('total_amt'),
                'discount' => $request->get('discount'),
                'discount_amt' => $request->get('discount_amt'),
                'net_amt' => round($request->get('net_amt')),
                'payment' => round($request->get('payment')),
                'payment_date' =>  $request->payment_date,
                // 'user_type' =>  $request->get('user_type'),
                'invoice_date' => $request->invoice_date,
                'delivery_date' => $request->get('delivery_date'),
            ];
            $ledgerBook = PurchaseLedgerBook::create($ledgerBook);

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
                toast('Sales Invoice Successfully Inserted', 'success');
                return redirect()->route('product-purchase.show', $supplier_id);
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
        // if ($error = $this->authorize('sales-sales-show')) {
        //     return $error;
        // }
        $supplierInfo = PurchaseInvoice::where('supplier_id', $id)->first();
        $getChallan = PurchaseInvoice::where('supplier_id', $id)->latest()->get();
        $supplierChallans = $getChallan->groupBy('challan_no');
        if ($supplierInfo == '') {
            alert()->info('Alert', 'There are no invoice. First create invoice');
            return redirect()->back();
        }
        return view('admin.purchase.product.ind_invoice', compact('supplierChallans', 'supplierInfo'));
    }

    //Edit invoice
    public function edit($user_id, $challan_no)
    {
        if ($error = $this->authorize('sales-sales-reinvoice')) {
            return $error;
        }
        $customer = User::where('id', $user_id)->first();
        $userId = SalesReport::with(['userForSR' => function ($q) {
            return $q->select('id', 'tmm_so_id', 'name', 'role')->whereIn('role', ['1','5']);
        }])->distinct('user_id')->get(['user_id']);

        $ledger = PurchaseLedgerBook::where('supplier_id', $user_id)->orderBy('id', 'DESC')->get();
        $ledgerPayment = PurchaseLedgerBook::where('supplier_id', $user_id)->get();

        // for update
        $invoices = PurchaseInvoice::where('challan_no', $challan_no)->where('inv_cancel', 0)->get();
        $ledgerUpdate = PurchaseLedgerBook::where('supplier_id', $user_id)->where('challan_no', $challan_no)->first();
        if ($ledgerUpdate->inv_cancel != 0) {
            alert()->info('Alert', 'The Invoice has already been canceled');
            return redirect()->back();
        }
        $invoice_no = PurchaseLedgerBook::select(['invoice_no','type'])->whereIn('type', [1,3,5])->count() + 697;
        $challan_no = PurchaseLedgerBook::select(['challan_no','type'])->whereIn('type', [1,3,5])->count() + 665;

        return view('admin.purchase.product.edit', compact('invoices', 'customer', 'userId', 'ledgerPayment', 'ledger', 'ledgerUpdate', 'invoice_no', 'challan_no'));
    }

    // Reinvoice ___________________________
    public function update(Request $request)
    {
        if ($error = $this->authorize('sales-sales-reinvoice')) {
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
        $transaction_id = transaction_id('RIN');
        DB::beginTransaction();

        $cancelInvoice = PurchaseInvoice::where('challan_no', $cancel_challan_no)->whereIn('type', [1,3])->update(['inv_cancel' => 2]);
        $cancelLedger = PurchaseLedgerBook::where('challan_no', $cancel_challan_no)->whereIn('type', [1,3])->update(['inv_cancel' => 2, 'sales_amt'=>0, 'discount'=>0, 'discount_amt'=>0, 'net_amt'=>0]);
        SalesReport::where('sales_ledger_book_id', $cancel_led_id)->delete() || '';

        $stock = Stock::whereIn('inv_id', $invoice_id)->whereIn('type', [1,3])->update(['inv_cancel' => 1]) || false;

        if ($request->cancel_note) {
            $cancelSampleNote = [
                'sales_ledger_book_id' => $cancel_led_id,
                'note' => $request->cancel_note
            ];
            SampleNote::where('sales_ledger_book_id', $cancel_led_id)->update($cancelSampleNote) || SampleNote::create($cancelSampleNote);
        }

        $supplier_id = $request->get('supplier_id');
        $invoice_no = $request->get('invoice_no');
        $challan_no = $request->get('challan_no');
        $user_id = $request->get('user_id');

        $ledgerBookCheck = PurchaseLedgerBook::whereIn('type', [1,3])->where('invoice_no', $request->invoice_no)->get();
        if ($ledgerBookCheck->count() > 0) {
            alert()->error('ErrorAlert', 'Something went wrong! Please try again');
            return redirect()->back();
        } else {
            // DB::beginTransaction();
            $invoiceArr = [];
            foreach ($request->product_id as $key => $v) {
                $data=[
                    'tran_id' => $transaction_id,
                    'user_id' => $user_id,
                    'supplier_id' => $supplier_id,
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
                $invoice = PurchaseInvoice::create($data);
                $invoiceArr[] = $invoice->id;
            };

            // Store Stock Start
            // foreach ($request->quantity as $i => $qty) {
            //     $stok = ProductStock::where('product_id', $request->product_id[$i])->where('product_pack_size_id', $request->size[$i])->whereIn('type', [1,3])->first();
            //     $quantity   = $stok->quantity;
            //     $stockUpdate['quantity']    = $quantity - $qty - $request->bonus[$i];
            //     $stok->update($stockUpdate);
            // }
            // New Stock
            foreach ($request->quantity as $key => $v) {
                $data=[
                    'tran_id' => $transaction_id,
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
                'tran_id' => $transaction_id,
                'user_id' => $user_id,
                'supplier_id' => $supplier_id,
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
            $ledgerBook = PurchaseLedgerBook::create($ledgerBook);

            $salesReport = SalesReport::where('user_id', $request->user_id)->first();
            $report = [
                'tran_id' => $transaction_id,
                'user_id' => $salesReport->user_id,
                'type' => 1,
                'inv_type' => $request->inv_type,
                'sales_ledger_book_id' => $ledgerBook->id,
                'zsm_id' => $salesReport->zsm_id,
                'sso_id' => $salesReport->sso_id,
                'so_id' => $salesReport->so_id,
                'supplier_id' => $supplier_id,
                'invoice_date' => $request->invoice_date,
                'discount_amt' =>  $request->discount_amt,
                'amt' => round(array_sum($request->get('amt')) - $discount),
            ];
            SalesReport::create($report);

            if ($request->note) {
                $sampleNote = [
                    'tran_id' => $transaction_id,
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
                        'tran_id' => $transaction_id,
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
                return redirect()->route('sales-invoice-cash.show', $supplier_id);
            } catch (\Exception $ex) {
                DB::rollBack();
                toast($ex->getMessage().'Sales Invoice Inserted Failed', 'error');
                return back();
            }
        }
    }

    public function cancelInv($challan_no)
    {
        if ($error = $this->authorize('sales-sales-cancel-invoice')) {
            return $error;
        }
        DB::transaction(function () use($challan_no){
            $invoice_id = PurchaseInvoice::where('challan_no', $challan_no)->whereIn('type', [1,3])->get()->pluck('id');
            $cancelInvoice = PurchaseInvoice::where('challan_no', $challan_no)->whereIn('type', [1,3]);
            if ($cancelInvoice->first()->inv_cancel != 0) {
                Alert::info('The Invoice has already been canceled');
                return redirect()->back();
            }
            PurchaseInvoice::whereIn('id', $invoice_id)->update(['inv_cancel' => 1]);
            $cancelLedger = PurchaseLedgerBook::where('challan_no', $challan_no)->whereIn('type', [1,3]);
            $cancel_led_id = $cancelLedger->first()->id;
            $cancelLedger->update(['inv_cancel' => 1, 'sales_amt'=>0, 'discount'=>0, 'discount_amt'=>0, 'net_amt'=>0]);
            SalesReport::where('sales_ledger_book_id', $cancel_led_id)->delete() || false;
            Stock::whereIn('inv_id', $invoice_id)->whereIn('type', [1,3])->update(['inv_cancel' => 1]) || false;
        });

        try{
            toast('success', 'success');
            return redirect()->back();
        }catch (\Exception $ex){
            toast('success', 'error');
            return redirect()->back();
        }
    }

    public function delete($invoice_id, $challan_no)
    {
        if ($error = $this->authorize('sales-sales-cancel-invoice')) {
            return $error;
        }
        DB::transaction(function () use($invoice_id, $challan_no){
            $invoiceCheck = PurchaseInvoice::where('challan_no', $challan_no)->where('inv_cancel', 0)->whereIn('type', [1,3])->get();
            if ($invoiceCheck->count() < 2) {
                Alert::info('Alert', 'Must have at least one data');
                return redirect()->back();
            }
            $invoice = PurchaseInvoice::where('id', $invoice_id)->whereIn('type', [1,3])->first();
            $invData['inv_cancel'] = 1;

            $stock = Stock::where('inv_id', $invoice_id)->whereIn('type', [1,3])->first();
            if ($stock) {
                $stock->update(['inv_cancel' => 1]);
            }
            $invoice->update($invData);
        });

        try{
            toast('success', 'success');
            return redirect()->back();
        }catch (\Exception $ex){
            toast('success', 'error');
            return redirect()->back();
        }
    }

    // ind show
    public function showInvoice($supplier_id, $invoice_no)
    {
        if ($error = $this->authorize('sales-sales-show')) {
            return $error;
        }
        $showInvoices = PurchaseInvoice::where('supplier_id', $supplier_id)->where('invoice_no', $invoice_no)->whereIn('type', [1,3])->get();
        $customerInfo = PurchaseInvoice::where('invoice_no', $invoice_no)->where('supplier_id', $supplier_id)->whereIn('type', [1,3])->first();
        $total_amt = PurchaseLedgerBook::where('invoice_no', $invoice_no)->whereIn('type', [1,3])->first();
        return view('admin.purchase.product.show_invoice', compact('showInvoices', 'customerInfo', 'total_amt'));
    }

    // All invoice
    public function allInvoice()
    {
        if ($error = $this->authorize('sales-sales-all-challan-and-invoice')) {
            return $error;
        }
        $getChallan = PurchaseInvoice::whereIn('type', [1,3])->latest()->get();
        $supplierChallans = $getChallan->groupBy('invoice_no');
        return view('admin.purchase.product.all_invoice', compact('supplierChallans'));
    }

    public function allInvoiceShow($invoice_no)
    {
        $showInvoices = PurchaseInvoice::where('invoice_no', $invoice_no)->whereIn('type', [1,3])->get(); // 1 = Sales of Cash
        $supplierInfo = PurchaseInvoice::whereIn('type', [1,3])->first();
        return view('admin.purchase.product.all_invoice_show', compact('showInvoices', 'supplierInfo'));
    }

    // All by date
    public function selectDate()
    {
        if ($error = $this->authorize('sales-sales-all-challan-and-invoice-by-date')) {
            return $error;
        }
        return view('admin.purchase.product.select_date');
    }

    public function allInvoiceByDate(Request $request)
    {
        if ($error = $this->authorize('sales-sales-all-challan-and-invoice-by-date')) {
            return $error;
        }
        $form_date = $request->get('form_date');
        $to_date = $request->get('to_date');

        $getChallan = PurchaseInvoice::whereBetween('invoice_date', [$form_date,$to_date])->whereIn('type', [1,3])->latest()->get();
        $supplierChallans = $getChallan->groupBy('invoice_no');
        return view('admin.purchase.product.all_invoice_by_date', compact('supplierChallans'));
    }

    // public function allInvoiceShowByDate($invoice_no)
    // {
    //     $showInvoices = PurchaseInvoice::where('invoice_no', $invoice_no)->whereIn('type', [1,3])->get(); // 1 = Sales of Cash
    //     $customerInfo = PurchaseInvoice::where('type', 7)->first();
    //     return view('admin.purchase.product.all_invoice_show_by_date', compact('showInvoices', 'customerInfo'));
    // }

    public function printInvoice($supplier_id, $invoice_no)
    {
        if ($error = $this->authorize('sales-sales-invoice')) {
            return $error;
        }
        $getShowInvoices = PurchaseInvoice::where('supplier_id', $supplier_id)->where('invoice_no', $invoice_no)->whereIn('type', [1,3])->get();
        $showInvoices = $getShowInvoices->groupBy('product_id');

        $invoiceDue = InvoiceDue::where('invoice_no', $invoice_no)->get();
        $invoiceDueFirst = InvoiceDue::where('invoice_no', $invoice_no)->first();
        $ledger = PurchaseLedgerBook::where('invoice_no', $invoice_no)->whereIn('type', [1,3])->first();
        return view('admin.purchase.product.print_invoice', compact('showInvoices', 'invoiceDue', 'ledger', 'invoiceDueFirst', 'getShowInvoices'));
    }

    public function printChallan($supplier_id, $invoice_no)
    {
        if ($error = $this->authorize('sales-sales-challan')) {
            return $error;
        }
        $getShowInvoices = PurchaseInvoice::where('supplier_id', $supplier_id)->where('invoice_no', $invoice_no)->whereIn('type', [1,3])->get();
        $showInvoices = $getShowInvoices->groupBy('product_id');

        $invoiceDue = InvoiceDue::where('invoice_no', $invoice_no)->get();
        $invoiceDueFirst = InvoiceDue::where('invoice_no', $invoice_no)->first();
        $ledger = PurchaseLedgerBook::where('invoice_no', $invoice_no)->whereIn('type', [1,3])->first();
        return view('admin.purchase.product.print_challan', compact('showInvoices', 'invoiceDue', 'ledger', 'invoiceDueFirst'));
    }
}
