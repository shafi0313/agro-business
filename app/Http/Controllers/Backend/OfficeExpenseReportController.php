<?php

namespace App\Http\Controllers\Backend;

use App\Models\Account;
use Illuminate\Http\Request;
use App\Models\OfficeExpenseCat;
use App\Http\Controllers\Controller;

class OfficeExpenseReportController extends Controller
{
    public function selectDate()
    {
        $expenseCats = OfficeExpenseCat::whereType(1)->whereParent_id(0)->get();
        return view('admin.office_expense.report.select_date', compact('expenseCats'));
    }

    public function report(Request $request)
    {
        $form_date = $request->get('form_date');
        $to_date = $request->get('to_date');


        if ($request->exp_type != 'sup') {
            $expenseCat = OfficeExpenseCat::find($request->exp_type);
            $exp_type = $request->exp_type;
            $getAccounts = Account::where('ac_type', 1)->whereNotNull('office_expense_cat_id')->whereExp_type($request->exp_type)->whereBetween('date', [$form_date, $to_date])->get();
            $accounts = $getAccounts->groupBy('office_expense_cat_id');
            return view('admin.office_expense.report.report', compact('form_date', 'to_date', 'accounts', 'getAccounts','expenseCat'));
        } else {
            $getAccounts = Account::where('ac_type', 1)->whereNotNull('user_id')->whereBetween('date', [$form_date, $to_date])->get();
            $accounts = $getAccounts->groupBy('user_id');
            return view('admin.office_expense.report.report_sup', compact('form_date', 'to_date', 'accounts', 'getAccounts',));
        }
    }

    public function reportView($id, $form_date, $to_date, $expCat)
    {
        $supReport = preg_replace('/[^a-z A-Z]/', '', $id);
        $supId = preg_replace('/[^0-9]/', '', $id);

        if (empty($supReport)) {
            $expenseCat = OfficeExpenseCat::find($expCat);
            $accounts = Account::where('office_expense_cat_id', $id)->whereBetween('date', [$form_date, $to_date])->get();
            return view('admin.office_expense.report.report_view', compact('accounts','expenseCat'));
        } else {
            $accounts = Account::where('user_id', $supId)->whereBetween('date', [$form_date, $to_date])->get();
            return view('admin.office_expense.report.report_sup_view', compact('accounts'));
        }
    }
}
