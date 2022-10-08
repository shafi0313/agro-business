<?php

namespace App\Http\Controllers\Backend;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Account;
use App\Models\Product;
use App\Models\SalesLedgerBook;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {

        $customers = User::select(['role'])->where('role', 2)->count();
        $supplier = User::select(['role'])->where('role', 3)->count();
        $employee = User::select(['role'])->where('role', 5)->count();
        $products = Product::count();

        // $purchase = PurchaseInvoice::select(['type','amt'])->where('type', 0)->sum('amt');
        // $purchaseReturn = PurchaseInvoice::select(['type','amt'])->where('type', 1)->sum('amt');
        // $totalPurchase = $purchase - $purchaseReturn;

        // $debit = Account::select(['debit'])->sum('debit');
        // $credit = Account::select(['credit'])->sum('credit');
        $todaysSale = SalesLedgerBook::whereDate('invoice_date',now())->whereIn('type',[1,3,16,18])->sum('net_amt');
        $todaysCollection = Account::whereDate('date',now())->sum('credit');
        // $todaysCollection = Account::whereDate('date',now())->whereIn('trn_type',[2,3])->sum('credit');
        $todaysExpense = Account::whereDate('date',now())->sum('debit');
        // $todaysExpense = Account::whereDate('date',now())->whereIn('trn_type',[1])->sum('debit');

        // This week's account
        $data['thisWeekSale'] = SalesLedgerBook::whereBetween('invoice_date', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->whereIn('type',[1,3,16,18])->sum('net_amt');
        $data['thisWeekCollection'] = Account::whereBetween('date', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->sum('credit');
        $data['thisWeekExpense'] = Account::whereBetween('date', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->sum('debit');
        // This month's account
        $data['thisMonthSale'] = SalesLedgerBook::whereMonth('invoice_date', Carbon::now()->month)->whereIn('type',[1,3,16,18])->sum('net_amt');
        $data['thisMonthCollection'] = Account::whereMonth('date', Carbon::now()->month)->sum('credit');
        $data['thisMonthExpense'] = Account::whereMonth('date', Carbon::now()->month)->sum('debit');

        // $productStocks = ProductStock::where('type', 1)->get();
        // $materialStocks = ProductStock::where('type', 2)->get();


        return view('admin.dashboard', compact('customers','employee','supplier', 'products', 'todaysSale', 'todaysCollection', 'todaysExpense','data'));
    }
}
