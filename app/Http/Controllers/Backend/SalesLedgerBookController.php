<?php

namespace App\Http\Controllers\Backend;

use PDF;
use Dompdf\Dompdf;
use App\Models\User;
use App\Models\SalesReport;
use App\Models\SalesInvoice;
use Illuminate\Http\Request;
use App\Models\SalesLedgerBook;
use Illuminate\Support\Facades\App;
use App\Http\Controllers\Controller;

class SalesLedgerBookController extends Controller
{
    public function index()
    {
        $customers = User::with(['invoice' => function($q){
            return $q->select('customer_id','payment_date','c_status','inv_cancel')
            ->whereNotNull('payment_date')->where('c_status',0)
            ->whereInv_cancel(0)
            ->where('payment_date', '<', date('Y-m-d'))
            ->count();
        }])->where('role', 2)->orWhere('id', 10)->orderby('business_name', 'ASC')->get(['id','business_name','name','phone','address']);

        return view('admin.sales.ledger_book.index', compact('customers'));
    }

    public function ledgerBookSelectDate(User $customer_id)
    {
        $customer_Info = SalesInvoice::where('customer_id', $customer_id->id)->get();
        return view('admin.sales.ledger_book.ind_select_date', compact('customer_Info', 'customer_id'));
    }

    // Ledger Book By Date
    public function showInvoice(Request $request)
    {
        $customer_id = $request->get('customer_id');
        $form_date = $request->get('form_date');
        $to_date = $request->get('to_date');

        $customer_Info = User::where('id', $customer_id)->first();
        $invoices = SalesLedgerBook::where('customer_id', $customer_id)
                    ->whereBetween('invoice_date', [$form_date,$to_date])
                    ->orderBy('challan_no', 'DESC')
                    ->where('type', 1)
                    ->orWhere('type', 2)
                    ->orWhere('type', 3)
                    ->orWhere('type', 4)
                    ->orWhere('type', 5)
                    ->orWhere('type', 7)
                    ->orWhere('type', 8)
                    ->orWhere('type', 16)
                    ->orWhere('type', 17)
                    ->orWhere('type', 18)
                    ->orWhere('type', 19)
                    ->orWhere('type', 25)
                    ->get();
        $salesInvoices = SalesLedgerBook::where('customer_id', $customer_id)
                    ->whereBetween('invoice_date', [$form_date,$to_date])
                    ->where('type', 1)
                    ->orWhere('type', 2)
                    ->orWhere('type', 3)
                    ->orWhere('type', 4)
                    ->orWhere('type', 5)
                    ->orWhere('type', 7)
                    ->orWhere('type', 8)
                    ->orWhere('type', 16)
                    ->orWhere('type', 17)
                    ->orWhere('type', 18)
                    ->orWhere('type', 19)
                    ->orWhere('type', 25)
                    ->get();
        $payment = SalesLedgerBook::where('customer_id', $customer_id)->whereBetween('invoice_date', [$form_date,$to_date])->where('type', 25)->get();
        // if($customer_Info == ''){
        //     alert()->info('Alert','There are no data available.');
        //     return redirect()->back();
        // }
        return view('admin.sales.ledger_book.ind_date_ledger_book', compact('customer_Info', 'invoices', 'salesInvoices', 'form_date', 'to_date', 'payment'));
    }

    // Ledger Book All
    public function indAllLedgerBook($customer_id)
    {
        $customer_Info = User::with(['customerInfo' => function($q){
            return $q->select('user_id','credit_limit');
        }])->select('id','business_name','name','phone','address')->where('id', $customer_id)->first();

        // return$customer_Info = User::where('id', $customer_id)->first();
        $openingBl = SalesLedgerBook::where('customer_id', $customer_id)->where('type', 0)->first();
        $invoices = SalesLedgerBook::with(['invoice' => function($q){
                    return $q->select('id','pro_dis','invoice_no');
                }])
                ->with(['account' => function($q){
                    return $q->select('id','m_r_date','m_r_no','payment_by','note');
                }])
                ->where('customer_id', $customer_id)
                ->where(function ($q) {
                    return $q->where('type', 0)
                        ->orWhere('type', 1)
                        ->orWhere('type', 2)
                        ->orWhere('type', 3)
                        ->orWhere('type', 4)
                        ->orWhere('type', 5)
                        ->orWhere('type', 7)
                        ->orWhere('type', 8)
                        ->orWhere('type', 16)
                        ->orWhere('type', 17)
                        ->orWhere('type', 18)
                        ->orWhere('type', 19)
                        ->orWhere('type', 25);
                })
                ->get(['id','account_id','payment_date','c_status','inv_cancel','invoice_date','invoice_no','type','sales_amt','discount','discount_amt','net_amt','payment_date','payment']);
        $payment = SalesLedgerBook::where('customer_id', $customer_id)->where('type', 25)->sum('payment');
        return view('admin.sales.ledger_book.ind_all_ledger_book', compact('customer_Info', 'invoices', 'payment', 'openingBl'));
    }

    public function allShowInvoice()
    {
        $invoices = SalesLedgerBook::orderBy('challan_no', 'DESC')
                    ->where('type', 1)
                    ->orWhere('type', 2)
                    ->orWhere('type', 3)
                    ->orWhere('type', 4)
                    ->orWhere('type', 5)
                    ->orWhere('type', 7)
                    ->orWhere('type', 8)
                    ->orWhere('type', 16)
                    ->orWhere('type', 17)
                    ->orWhere('type', 18)
                    ->orWhere('type', 19)
                    ->orWhere('type', 25)
                    ->get();
        $salesAmt = SalesLedgerBook::orderBy('challan_no', 'DESC')
                    ->where('type', 1)
                    ->orWhere('type', 2)
                    ->orWhere('type', 3)
                    ->orWhere('type', 4)
                    ->orWhere('type', 5)
                    ->orWhere('type', 7)
                    ->orWhere('type', 8)
                    ->orWhere('type', 16)
                    ->orWhere('type', 17)
                    ->orWhere('type', 18)
                    ->orWhere('type', 19)
                    ->orWhere('type', 25)
                    ->get();
        $payment = SalesLedgerBook::where('type', 25)->get();
        return view('admin.sales.ledger_book.all_ledger_book', compact('invoices', 'salesAmt', 'payment'));
    }

    public function ledgerReportEdit($id)
    {
        if ($error = $this->sendPermissionError('edit')) {
            return $error;
        }
        $ledgerBook = SalesLedgerBook::find($id);
        return view('admin.sales.ledger_book.ledger_edit', compact('ledgerBook'));
    }
    public function ledgerReportUpdate(Request $request, $id)
    {
        $data = [
            'sales_amt' => $request->sales_amt,
            'discount' => $request->discount,
            'net_amt' => $request->net_amt,
        ];

        $salesReport = [
            'amt' => $request->net_amt
        ];

        try {
            SalesReport::where('sales_ledger_book_id', $id)->update($salesReport);
            SalesLedgerBook::find($id)->update($data);
            toast(' Successfully Update', 'success');
            return redirect()->back();
        } catch (\Exception $ex) {
            toast('Update Faild', 'error');
            return redirect()->back();
        }
    }
}
