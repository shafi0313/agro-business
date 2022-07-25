<?php

namespace App\Http\Controllers\Backend;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\SalesInvoice;
use App\Models\SalesLedgerBook;

class CustomerReportController extends Controller
{
    public function index()
    {
        if ($error = $this->authorize('customer-report-manage')) {
            return $error;
        }
        $customers = User::with(['invoice' => function ($q) {
            return $q->select('id', 'type', 'customer_id', 'sales_amt', 'discount_amt', 'net_amt', 'payment', 'pay_type');
        }])
                ->where('role', 2)
                ->orderby('business_name', 'ASC')
                ->get(['id','name','business_name','phone','tmm_so_id']);

        $salesLedgerBook = SalesLedgerBook::select(['type','sales_amt','discount_amt','net_amt','payment','pay_type','customer_id'])->get();
        return view('admin.customer_report.index', compact('customers', 'salesLedgerBook'));
    }
}
