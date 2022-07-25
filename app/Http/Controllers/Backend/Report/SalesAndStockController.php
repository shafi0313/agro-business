<?php

namespace App\Http\Controllers\Backend\Report;

use App\Http\Controllers\Controller;
use App\Models\PurchaseInvoice;
use App\Models\PurchaseLedgerBook;
use App\Models\SalesInvoice;
use App\Models\SalesLedgerBook;
use Illuminate\Http\Request;

class SalesAndStockController extends Controller
{
    public function selectDate()
    {
        return view('admin.report.sales_and_stock.select_date');
    }

    public function salesReport(Request $request)
    {
        if ($error = $this->authorize('sales-report-manage')) {
            return $error;
        }
        $form_date = $request->get('form_date');
        $to_date = $request->get('to_date');

        $reports = SalesInvoice::whereBetween('invoice_date', [$form_date,$to_date])->whereIn('type', [1,3])->whereInv_cancel(0)->latest()->get();
        $reportWithDiscount = SalesLedgerBook::whereBetween('invoice_date', [$form_date,$to_date])->whereIn('type', [1,3])->whereInv_cancel(0)->latest()->get();
        return view('admin.report.sales_and_stock.sales_report', compact('reports','form_date','to_date','reportWithDiscount'));
    }

    public function salesReturnReport(Request $request)
    {
        if ($error = $this->authorize('sales-return-report-manage')) {
            return $error;
        }
        $form_date = $request->get('form_date');
        $to_date = $request->get('to_date');

        $reports = SalesInvoice::whereBetween('invoice_date', [$form_date,$to_date])->whereIn('type', [2,4])->whereInv_cancel(0)->latest()->get();
        $reportWithDiscount = SalesLedgerBook::whereBetween('invoice_date', [$form_date,$to_date])->whereIn('type', [2,4])->whereInv_cancel(0)->latest()->get();
        return view('admin.report.sales_and_stock.sales_return_report', compact('reports','form_date','to_date','reportWithDiscount'));
    }

    public function sampleReport(Request $request)
    {
        if ($error = $this->authorize('sample-report-manage')) {
            return $error;
        }
        $form_date = $request->get('form_date');
        $to_date = $request->get('to_date');

        $reports = SalesInvoice::whereBetween('invoice_date', [$form_date,$to_date])->where('type', 5)->whereInv_cancel(0)->latest()->get();
        $reportWithDiscount = SalesLedgerBook::whereBetween('invoice_date', [$form_date,$to_date])->where('type', 5)->whereInv_cancel(0)->latest()->get();
        return view('admin.report.sales_and_stock.sample_report', compact('reports','form_date','to_date','reportWithDiscount'));
    }

    public function productionReport(Request $request)
    {
        if ($error = $this->authorize('production-report-manage')) {
            return $error;
        }

        $form_date = $request->get('form_date');
        $to_date = $request->get('to_date');

        $reports = PurchaseInvoice::whereBetween('invoice_date', [$form_date,$to_date])->where('type', 11)->whereInv_cancel(0)->latest()->get();
        $reportWithDiscount = PurchaseLedgerBook::whereBetween('invoice_date', [$form_date,$to_date])->where('type', 11)->whereInv_cancel(0)->latest()->get();

        return view('admin.report.sales_and_stock.production_report', compact('reports','form_date','to_date','reportWithDiscount'));
    }
}
