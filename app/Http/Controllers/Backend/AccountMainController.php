<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Account;

class AccountMainController extends Controller
{
    public function selectDate()
    {
        if ($error = $this->authorize('main-account-manage')) {
            return $error;
        }
        return view('admin.account.main_account.select_date');
    }

    public function index(Request $request)
    {
        if ($error = $this->authorize('main-account-manage')) {
            return $error;
        }
        $form_date = $request->get('form_date');
        $to_date = $request->get('to_date');
        $opening = Account::where('date', '<', $form_date);
        $accounts = Account::whereBetween('date',[$form_date,$to_date])->get();
        return view('admin.account.main_account.index', compact('accounts','form_date','to_date','opening'));
    }
}
