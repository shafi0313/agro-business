<?php

namespace App\Http\Controllers\Sales;

use App\Models\User;
use App\Models\Stock;
use App\Models\Account;
use App\Models\Product;
use App\Models\BankList;
use App\Models\InvoiceDue;
use App\Models\SampleNote;
use App\Models\SalesReport;
use App\Models\ProductStock;
use App\Models\SalesInvoice;
use Illuminate\Http\Request;
use App\Models\SalesLedgerBook;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class CreateInvoiceController extends Controller
{
    public function create()
    {
        if ($error = $this->authorize('sales-sales-sales')) {
            return $error;
        }
        $customers = User::with(['customerInfo' => function ($q) {
            return $q->select('user_id', 'type', 'credit_limit');
        }])->select('id', 'role', 'name', 'business_name', 'address')->orderBy('name')->whereRole(2)->get();
        $products = Product::whereType(1)->orderBy('name')->get(['id', 'name']);

        // $userId = SalesReport::with(['userForSR' => function ($q) {
        //     return $q->select('id', 'tmm_so_id', 'name', 'role')->whereIn('role', ['1','5']);
        // }])->distinct('user_id')->get(['user_id']);

        $invoice_no = SalesLedgerBook::select(['invoice_no','type'])->whereIn('type', [1,3,5])->count() + 697;
        $challan_no = SalesLedgerBook::select(['challan_no','type'])->whereIn('type', [1,3,5])->count() + 665;

        $bankLists = BankList::all();

        // $ledgerPayment = SalesLedgerBook::where('customer_id', $id)->get(['net_amt','payment']);
        return view('admin.sales.create_invoice.create', compact('customers', 'products', 'invoice_no', 'challan_no', 'bankLists'));
    }

    public function store(Request $request)
    {
        if ($error = $this->authorize('sales-sales-sales')) {
            return $error;
        }
        $this->validate($request, [
            'invoice_no'   => 'required',
            'size_id'      => 'required',
            'quantity'     => 'required',
            'rate_per_qty' => 'required',
            'invoice_date' => 'required',
            'amt'          => 'required',
        ]);

        $customer_id = $request->get('customer_id');
        $invoice_no = $request->get('invoice_no');
        $challan_no = $request->get('challan_no');
        $user_id = $request->get('user_id');
        $transaction_id = transaction_id('INV');

        DB::beginTransaction();

        $ledgerBookCheck = SalesLedgerBook::whereIn('type', [1,3])->where('invoice_no', $request->invoice_no)->get();
        if ($ledgerBookCheck->count() > 0) {
            alert()->error('Error Alert', 'Something went wrong! Please try again');
            return redirect()->back();
        } else {
            $invoiceArr = [];
            foreach ($request->product_id as $key => $v) {
                $data=[
                    'tran_id' => $transaction_id,
                    // 'user_id' => $user_id,
                    'customer_id' => $customer_id,
                    'product_id' => $request->product_id[$key],
                    'type' => $request->filled('payment_by') ? 1 : 3, // Cash
                    'invoice_no' => $invoice_no,
                    'challan_no' => $challan_no,
                    'size' => $request->size_id[$key],
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

            // New Stock
            foreach ($request->quantity as $key => $v) {
                $data=[
                    'tran_id'              => $transaction_id,
                    'inv_id'               => $invoiceArr[$key],
                    'product_id'           => $request->product_id[$key],
                    'product_pack_size_id' => $request->size_id[$key],
                    'type'                 => $request->filled('payment_by') ? 1 : 3,
                    'stock_type'           => 1, //Store
                    'challan_no'           => $challan_no,
                    'quantity'             => $request->quantity[$key],
                    'bonus'                => $request->bonus[$key],
                    'amt'                  => round($request->amt[$key]) - round($request->amt[$key])*$request->pro_dis[$key]/100,
                    'dis'                  => $request->pro_dis[$key],
                    'net_amt'              => round($request->amt[$key]),
                    'date'                 => $request->invoice_date,
                ];
                Stock::create($data);
            };
            // Store Stock End

            $ledgerBook = [
                'tran_id'      => $transaction_id,
                // 'user_id'      => $user_id,
                'customer_id'  => $customer_id,
                'prepared_id'  => auth()->user()->id,
                'type'         => $request->filled('payment_by') ? 1 : 3,
                'invoice_no'   => $invoice_no,
                'challan_no'   => $challan_no,
                'sales_amt'    => $request->get('total_amt'),
                'discount'     => $request->get('discount'),
                'discount_amt' => $request->get('discount_amt'),
                'net_amt'      => round($request->get('net_amt')),
                'payment'      => round($request->get('payment')),
                'payment_date' => $request->payment_date,
                // 'user_type' =>  $request->get('user_type'),
                'invoice_date'  => $request->invoice_date,
                'delivery_date' => $request->get('delivery_date'),
            ];
            $ledgerBook = SalesLedgerBook::create($ledgerBook);

            if(setting('inv_officer_id') == 1){
                $salesReport = SalesReport::where('user_id', $request->user_id)->first();
                $productDiscount = array_sum($request->pro_dis) / count($invoiceArr);
                $report = [
                    'tran_id'              => $transaction_id,
                    // 'user_id'              => $salesReport->user_id,
                    'type'                 => 1,
                    'inv_type'             => $request->filled('payment_by') ? 1 : 3,
                    'sales_ledger_book_id' => $ledgerBook->id,
                    'zsm_id'               => $salesReport->zsm_id,
                    'sso_id'               => $salesReport->sso_id,
                    'so_id'                => $salesReport->so_id,
                    'customer_id'          => $customer_id,
                    'invoice_date'         => $request->invoice_date,
                    'discount'             => $request->discount + $productDiscount,
                    'discount_amt'         => $request->discount_amt,
                    'amt'                  => round($request->net_amt),
                ];
                SalesReport::create($report);
            }

            if ($request->note) {
                $sampleNote = [
                    'sales_ledger_book_id' => $ledgerBook->id,
                    'note'                 => $request->note,
                    'tran_id'              => $transaction_id,
                ];
                SampleNote::create($sampleNote);
            }

            if($request->filled('payment_by')){
                $tmm_so_id = $request->get('tmm_so_id');
                $user_bank_ac_id = $request->get('user_bank_ac_id');
                $transaction_idRec = transaction_id('REC');
                $account = [
                    'tran_id'   => $transaction_idRec,
                    'user_id'   => $customer_id,
                    // 'tmm_so_id' => $tmm_so_id,
                    'ac_type'   => 2,
                    'trn_type'  => 2,                 // Rec
                    // 'pay_type' => $request->pay_type, // Rec
                    'pay_type'        => empty($request->pay_type) ? 3 : $request->pay_type,
                    'payment_by'      => $request->get('payment_by'),
                    'user_bank_ac_id' => $user_bank_ac_id,
                    'm_r_date'        => $request->get('m_r_date'),
                    'm_r_no'          => $request->get('m_r_no'),
                    'note'            => $request->get('note'),
                    'credit'          => round($request->get('credit')),
                    'date'            => $request->invoice_date,
                    'cheque_no'       => $request->get('cheque_no'),
                ];
                if (!$user_bank_ac_id) {
                    $account['type'] = 1; // Cash
                } else {
                    $account['type'] = 2; // Bank
                }
                $account = Account::create($account);
                if ($request->credit >= round($request->net_amt)) {
                    $c_status = 1;
                } else {
                    $c_status = 0;
                }
                $ledgerBook = [
                    'tran_id'      => $transaction_idRec,
                    // 'user_id'      => $tmm_so_id,
                    'customer_id'  => $customer_id,
                    'invoice_no'   => $invoice_no,
                    'prepared_id'  => auth()->user()->id,
                    'account_id'   => $account->id,
                    'type'         => 25,                                                   // Received
                    'pay_type'     => empty($request->pay_type) ? 3 : $request->pay_type,
                    'invoice_date' => $request->invoice_date,
                    'payment'      => round($request->get('credit')),
                    'payment_date' => $request->payment_date,
                    'c_status'     => 2,
                    'discount'     => $request->discount,
                    'discount_amt' => round($request->discount_amt),
                    'c_status'     => $c_status,
                ];
                $ledgerBookCreate = SalesLedgerBook::create($ledgerBook);
            }

            try {
                if((setting('inv_sms_service') == 1) && (env('SMS_API') != "")){
                    $customerPhone = User::find($customer_id)->phone;
                    $am = round($request->net_amt);
                    $pD = bdDate($request->payment_date);
                    $cNa = setting('app_name');
                    $msg = "New invoice: Dear customer an Invoice has been created under your Account. Invoice no: ".$invoice_no.", Amount: ".$am."BDT. Last payment date: ".$pD. $cNa.".";
                    sms($customerPhone, $msg);
                }
                DB::commit();
                toast('Sales Invoice Successfully Inserted', 'success');
                return back();
                // return redirect()->route('sales-invoice-cash.show', $customer_id);
            } catch (\Exception $ex) {
                // return $ex->getMessage();
                DB::rollBack();
                toast('Sales Invoice Inserted Failed', 'error');
                return back();
            }
        }
    }
}
