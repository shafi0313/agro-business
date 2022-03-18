<?php

namespace App\Http\Controllers\Backend;

use App\Models\User;
use App\Models\Account;
use App\Models\Product;
use App\Models\VisitorInfo;
use App\Models\ProductStock;
use App\Models\PurchaseInvoice;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        $customers = User::select(['role'])->where('role', 2)->count();
        $supplier = User::select(['role'])->where('role', 3)->count();
        $products = Product::count();

        $purchase = PurchaseInvoice::select(['type','amt'])->where('type', 0)->sum('amt');
        $purchaseReturn = PurchaseInvoice::select(['type','amt'])->where('type', 1)->sum('amt');
        $totalPurchase = $purchase - $purchaseReturn;

        $debit = Account::select(['debit'])->sum('debit');
        $credit = Account::select(['credit'])->sum('credit');

        $productStocks = ProductStock::where('type', 1)->get();
        $materialStocks = ProductStock::where('type', 2)->get();


        return view('admin.dashboard', compact('customers', 'supplier', 'products', 'totalPurchase',  'debit', 'credit', 'productStocks', 'materialStocks'));
    }
}
