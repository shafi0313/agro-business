<?php

namespace App\Http\Controllers\Backend;

use App\Models\SalesInvoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class StockReportController extends Controller
{
    public function index()
    {
        return view('admin.stock_report.index');
    }
    public function salesSelectDate()
    {
        return view('admin.stock_report.sales.select_date');
    }

    public function salesReport(Request $request)
    {
        $form_date = $request->get('form_date');
        $to_date = $request->get('to_date');
        $getSalesInvoice = DB::table('sales_invoices')
                ->join('products', 'sales_invoices.product_id', '=', 'products.id')
                ->orderBy('products.name')
                ->join('product_pack_sizes', 'sales_invoices.size', '=', 'product_pack_sizes.id')
                ->orderBy('product_pack_sizes.size')
                ->select('sales_invoices.*','products.id','products.name','product_pack_sizes.id','product_pack_sizes.size')
                ->whereBetween('invoice_date',[$form_date, $to_date])
                ->get()
                ->where('type', 1);
        $salesInvoices = $getSalesInvoice->groupBy(['product_id','size']);

        return view('admin.stock_report.sales.sales', compact('form_date','to_date','getSalesInvoice','salesInvoices'));
    }
}
