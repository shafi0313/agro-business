<?php

namespace App\Http\Controllers\Backend;

use App\Models\Account;
use Illuminate\Http\Request;
use App\Models\OfficeExpenseCat;
use App\Http\Controllers\Controller;

class OfficeIncomeReportController extends Controller
{
    public function selectDate()
    {
        $expenseCats = OfficeExpenseCat::whereType(2)->whereParent_id(0)->get();
        return view('admin.office_income.report.select_date', compact('expenseCats'));
    }

    public function report(Request $request)
    {
        $form_date = $request->get('form_date');
        $to_date = $request->get('to_date');

        if ($request->exp_type != 2) {
            $expenseCat = OfficeExpenseCat::find($request->exp_type);
            $getAccounts = Account::where('ac_type', 2)->whereNotNull('office_expense_cat_id')->whereType($request->exp_type)->whereBetween('date', [$form_date, $to_date])->get();
            $accounts = $getAccounts->groupBy('office_expense_cat_id');
            return view('admin.office_income.report.report', compact('form_date', 'to_date', 'accounts', 'getAccounts', 'expenseCat'));
        } else {
            $getAccounts = Account::where('ac_type', 2)->whereNotNull('user_id')->whereBetween('date', [$form_date, $to_date])->get();
            $accounts = $getAccounts->groupBy('user_id');
            return view('admin.office_income.report.report_customer', compact('form_date', 'to_date', 'accounts', 'getAccounts'));
        }
    }

    public function reportView($id, $form_date, $to_date, $expCat)
    {
        $cusReport = preg_replace('/[^a-z A-Z]/', '', $id);
        $cusId = preg_replace('/[^0-9]/', '', $id);
        if (empty($cusReport)) {
            $expenseCat = OfficeExpenseCat::find($expCat);
            $accounts = Account::where('office_expense_cat_id', $id)->whereBetween('date', [$form_date, $to_date])->get();
            return view('admin.office_income.report.report_view', compact('accounts','expenseCat'));
        } else {
            $accounts = Account::where('user_id', $cusId)->whereBetween('date', [$form_date, $to_date])->get();
            return view('admin.office_income.report.report_customer_view', compact('accounts'));
        }
    }
}
