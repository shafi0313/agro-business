<?php

namespace App\Http\Controllers\Backend\Report;

use App\Models\SalesInvoice;
use Illuminate\Http\Request;
use App\Models\PurchaseInvoice;
use App\Models\SalesLedgerBook;
use App\Models\PurchaseLedgerBook;
use App\Http\Controllers\Controller;

class BulkController extends Controller
{
    public function selectDate()
    {
        return view('admin.report.bulk.select_date');
    }

    public function sales(Request $request)
    {
        if ($error = $this->authorize('bulk-report-sales')) {
            return $error;
        }
        $form_date = $request->get('form_date');
        $to_date = $request->get('to_date');

        $reports = SalesInvoice::whereBetween('invoice_date', [$form_date,$to_date])->whereIn('type', [16,18])->whereInv_cancel(0)->latest()->get();
        $reportWithDiscount = SalesLedgerBook::whereBetween('invoice_date', [$form_date,$to_date])->whereIn('type', [16,18])->whereInv_cancel(0)->latest()->get();
        return view('admin.report.bulk.sales', compact('reports','form_date','to_date','reportWithDiscount'));
    }

    public function purchase(Request $request)
    {
        if ($error = $this->authorize('bulk-report-purchase')) {
            return $error;
        }
        $form_date = $request->get('form_date');
        $to_date = $request->get('to_date');

        $reports = PurchaseInvoice::whereBetween('invoice_date', [$form_date,$to_date])->whereIn('type', [7])->whereInv_cancel(0)->latest()->get();
        $reportWithDiscount = PurchaseLedgerBook::whereBetween('invoice_date', [$form_date,$to_date])->whereIn('type', [7])->whereInv_cancel(0)->get();
        return view('admin.report.bulk.purchase', compact('reports','form_date','to_date','reportWithDiscount'));
    }

    public function sendToRepackUnit(Request $request)
    {
        if ($error = $this->authorize('bulk-report-send-to-repack-unit')) {
            return $error;
        }
        $form_date = $request->get('form_date');
        $to_date = $request->get('to_date');

        $reports = PurchaseInvoice::whereBetween('invoice_date', [$form_date,$to_date])->whereIn('type', [9])->whereInv_cancel(0)->latest()->get();
        $reportWithDiscount = PurchaseLedgerBook::whereBetween('invoice_date', [$form_date,$to_date])->whereIn('type', [9])->whereInv_cancel(0)->latest()->get();
        return view('admin.report.bulk.sent_to_repack_unit', compact('reports','form_date','to_date','reportWithDiscount'));
    }
}
