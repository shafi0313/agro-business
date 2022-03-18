<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\SalesInvoice;
use Illuminate\Http\Request;

class TotalStockController extends Controller
{
    public function selectDate()
    {
        return view('admin.total_stock.select_date');
    }

    public function report(Request $request)
    {
        $form_date = $request->get('form_date');
        $to_date = $request->get('to_date');

        $totalStocks = SalesInvoice::whereBetween('invoice_date',[$form_date, $to_date])->get();

        return view('admin.total_stock.report', compact('form_date','to_date','totalStocks'));
    }
}
