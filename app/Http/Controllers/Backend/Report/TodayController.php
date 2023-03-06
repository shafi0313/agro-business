<?php

namespace App\Http\Controllers\Backend\Report;

use App\Models\Account;
use App\Models\SalesInvoice;
use Illuminate\Http\Request;
use App\Models\PurchaseInvoice;
use App\Http\Controllers\Controller;

class TodayController extends Controller
{
    public function show(Request $request)
    {
        // if ($error = $this->authorize('profit-loss-report')) {
        //     return $error;
        // }
        $start_date = $request->start_date;
        $end_date   = $request->end_date;

        $accounts = Account::whereDate('date', date('Y-m-d'))->get();
        $sales = SalesInvoice::whereDate('invoice_date', date('Y-m-d'))
                ->whereInv_cancel(0)
                ->whereIn('type', [1,3])
                ->get(['id','product_id','inv_cancel','type','size','quantity','amt','invoice_date'])
                ->groupBy('size');

        $purchases = PurchaseInvoice::whereDate('invoice_date', date('Y-m-d'))
                ->whereInv_cancel(0)
                ->whereIn('type', [30,32])
                ->get(['id','product_id','inv_cancel','type','size','quantity','amt','invoice_date'])
                ->groupBy('size');

        return view('admin.report.today.show', compact('accounts','sales','purchases'));
    }
}
