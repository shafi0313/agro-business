<?php

namespace App\Http\Controllers\Backend;

use App\Models\User;
use App\Models\SalesInvoice;
use Illuminate\Http\Request;
use App\Models\SalesLedgerBook;
use App\Http\Controllers\Controller;

class SalesStatementController extends Controller
{
    public function selectDate()
    {
        return view('admin.sales_statement.select_date');
    }

    public function report(Request $request)
    {
        $form_date = $request->get('form_date');
        $to_date = $request->get('to_date');

        $getsalesStatements = SalesLedgerBook::whereBetween('invoice_date',[$form_date,$to_date])->latest()->get();
        $salesStatements = $getsalesStatements->groupBy('customer_id');
        // $rStatements = SalesLedgerBook::whereBetween('invoice_date',[$form_date,$to_date])->where('invoice_status', 0)->where('invoice_status', 3)->latest()->get();

        return view('admin.sales_statement.statement', compact('salesStatements','form_date','to_date'));
    }
}
