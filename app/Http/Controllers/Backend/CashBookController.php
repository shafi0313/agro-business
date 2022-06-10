<?php

namespace App\Http\Controllers\Backend;

use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class CashBookController extends Controller
{
    public function selectDate()
    {
        return view('admin.account.cash_book.select_date');
    }

    public function report(Request $request)
    {
        $form_date = $request->get('form_date');
        $to_date = $request->get('to_date');

        $getBankAccountsOpen = Account::where('type', 2)->where('date', '<', $form_date);
        $bankOpening = $getBankAccountsOpen->sum('credit') - $getBankAccountsOpen->sum('debit');

        $getCashAccountsOpen = Account::where('type', 1)->where('date', '<', $form_date);
        $cashOpening = $getCashAccountsOpen->sum('credit') - $getCashAccountsOpen->sum('debit');

        $OfficeExpenses = Account::whereIn('type',[1,2])->whereNotNull('office_expense_cat_id')->whereBetween('date', [$form_date, $to_date])->get();

        $getOfficeExpCash = Account::where('type', 1)->whereNotNull('office_expense_cat_id')->whereBetween('date', [$form_date, $to_date]);
        $officeExpCash = $getOfficeExpCash->sum('credit') - $getOfficeExpCash->sum('debit');

        $getOfficeExpBank = Account::where('type', 2)->whereNotNull('office_expense_cat_id')->whereBetween('date', [$form_date, $to_date]);
        $officeExpBank = $getOfficeExpBank->sum('credit') - $getOfficeExpBank->sum('debit');

        $accounts = Account::with('userBank')
                        ->whereNull('office_expense_cat_id')
                        ->whereBetween('date', [$form_date, $to_date])
                        ->get(['id','user_bank_ac_id','date','note','trn_type','type','m_r_no','debit','credit']);
                        
        $accountsTotal = Account::whereBetween('date', [$form_date, $to_date]);
        $accountsTotalCredit = $accountsTotal->sum('credit');
        $accountsTotalDebit = $accountsTotal->sum('debit');

        return view('admin.account.cash_book.report', compact('form_date', 'to_date', 'accounts', 'bankOpening', 'cashOpening', 'officeExpCash', 'officeExpBank', 'accountsTotalCredit', 'accountsTotalDebit','OfficeExpenses'));
    }

    public function cashPreStore(Request $request)
    {
        if ($error = $this->sendPermissionError('create')) {
            return $error;
        }

        $this->validate($request, [
            'credit' => 'required|numeric',
            'date' => 'required'
        ]);

        $account = [
            'user_id' => null,
            'tmm_so_id' => null,
            'type' => 1,
            'ac_type' => 2,
            'trn_type' => 3,
            'note' => 'Previous',
            'credit' => $request->get('credit'),
            'date' => $request->get('date'),
        ];
        DB::beginTransaction();

        try {
            Account::create($account);
            DB::commit();
            toast('Success', 'success');
            return redirect()->route('cashBook.selectDate');
        } catch (\Exception $ex) {
            DB::rollBack();
            toast($ex->getMessage().'Inserted Failed', 'error');
            return redirect()->back();
        }
    }
}
