<?php

namespace App\Http\Controllers\Backend;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Account;
use App\Models\Product;
use App\Models\SalesLedgerBook;
use App\Models\PurchaseLedgerBook;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        $customers = User::select(['role'])->where('role', 2)->count();
        $supplier = User::select(['role'])->where('role', 3)->count();
        $employee = User::select(['role'])->where('role', 5)->count();
        $products = Product::count();

        // Today's Account
        $data['todaysSale'] = SalesLedgerBook::whereDate('invoice_date',now())->whereIn('type',[1,3,16,18])->sum('net_amt');
        $data['todaysSaleReturn'] = SalesLedgerBook::whereDate('invoice_date',now())->whereIn('type',[2,4,17,19])->sum('net_amt');
        $data['todaysPurchase'] = PurchaseLedgerBook::whereDate('invoice_date',now())->whereIn('type',[1,3])->sum('net_amt');
        $data['todaysCollection'] = Account::whereDate('date',now())->sum('credit');
        // $todaysCollection = Account::whereDate('date',now())->whereIn('trn_type',[2,3])->sum('credit');
        $data['todaysExpense'] = Account::whereDate('date',now())->sum('debit');
        // $todaysExpense = Account::whereDate('date',now())->whereIn('trn_type',[1])->sum('debit');
        $data['todaysPayment'] = Account::whereDate('date',now())->whereTrn_type(1)->sum('debit');
        $data['todaysProfitLoss'] = $data['todaysSale'] - ($data['todaysPurchase']  + abs($data['todaysSaleReturn']) + $data['todaysPayment']);

        // This week's account
        $data['thisWeekSale'] = SalesLedgerBook::whereBetween('invoice_date', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->whereIn('type',[1,3,16,18])->sum('net_amt');
        $data['thisWeekSaleReturn'] = SalesLedgerBook::whereBetween('invoice_date', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->whereIn('type',[2,4,17,19])->sum('net_amt');
        $data['thisWeekPurchase'] = PurchaseLedgerBook::whereBetween('invoice_date', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->whereIn('type',[1,3])->sum('net_amt');
        $data['thisWeekCollection'] = Account::whereBetween('date', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->sum('credit');
        $data['thisWeekExpense'] = Account::whereBetween('date', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->sum('debit');
        $data['thisWeekPayment'] = Account::whereBetween('date', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->whereTrn_type(1)->sum('debit');
        $data['thisWeekProfitLoss'] = $data['thisWeekSale'] - ($data['thisWeekPurchase']  + abs($data['thisWeekSaleReturn']) + $data['thisWeekPayment']);

        // This month's account
        $data['thisMonthSale'] = SalesLedgerBook::whereMonth('invoice_date', Carbon::now()->month)->whereIn('type',[1,3,16,18])->sum('net_amt');
        $data['thisMonthSaleReturn'] = SalesLedgerBook::whereMonth('invoice_date', Carbon::now()->month)->whereIn('type',[2,4,17,19])->sum('net_amt');
        $data['thisMonthPurchase'] = PurchaseLedgerBook::whereMonth('invoice_date', Carbon::now()->month)->whereIn('type',[1,3])->sum('net_amt');
        $data['thisMonthCollection'] = Account::whereMonth('date', Carbon::now()->month)->sum('credit');
        $data['thisMonthExpense'] = Account::whereMonth('date', Carbon::now()->month)->sum('debit');
        $data['thisMonthPayment'] = Account::whereMonth('date', Carbon::now()->month)->whereTrn_type(1)->sum('debit');
        $data['thisMonthProfitLoss'] = $data['thisMonthSale'] - ($data['thisMonthPurchase']  + abs($data['thisMonthSaleReturn']) + $data['thisMonthPayment']);

        return view('admin.dashboard', compact('customers','employee','supplier', 'products', 'data'));
    }
}
