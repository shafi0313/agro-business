<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\SalesInvoice;
use Illuminate\Http\Request;

class SalesSampleReportController extends Controller
{
    public function selectDate()
    {
        return view('admin.sales.sample_report.select_date');
    }

    public function report(Request $request)
    {
        $form_date = $request->get('form_date');
        $to_date = $request->get('to_date');

        $samples = SalesInvoice::where('type', 5)->whereBetween('invoice_date', [$form_date,$to_date])->get();

        return view('admin.sales.sample_report.report', compact('samples'));
    }
}
