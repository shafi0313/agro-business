<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Models\PurchaseLedgerBook;
use App\Http\Controllers\Controller;

class PurchaseStatementController extends Controller
{
    public function selectDate()
    {
        return view('admin.purchase_statement.select_date');
    }

    public function report(Request $request)
    {
        $form_date = $request->get('form_date');
        $to_date = $request->get('to_date');

        $getpurchaseStatements = PurchaseLedgerBook::whereBetween('invoice_date',[$form_date,$to_date])->latest()->get();
        $purchaseStatements = $getpurchaseStatements->groupBy('supplier_id');

        return view('admin.purchase_statement.statement', compact('purchaseStatements','form_date','to_date'));
    }
}
