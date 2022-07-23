<?php

namespace App\Http\Controllers\Backend;

use App\Models\User;
use App\Models\Account;
use App\Models\EmployeeInfo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AuthorLedgerBookController extends Controller
{
    public function index()
    {
        if ($error = $this->authorize('author-ledger-book-manage')) {
            return $error;
        }
        $authors = User::where('role', 1)->where('name', '!=', 'Developer')->orwhere('role', 5)->get();
        return view('admin.author_ledger_book.index', compact('authors'));
    }

    public function selectDate(User $user_id)
    {
        if ($error = $this->authorize('author-ledger-book-show-by-date')) {
            return $error;
        }
        $authorInfo = Account::where('user_id', $user_id->id)->get();
        return view('admin.author_ledger_book.ind_select_date', compact('authorInfo', 'user_id'));
    }

    // Ledger Book By Date
    public function showInvoice(Request $request)
    {
        if ($error = $this->authorize('author-ledger-book-show-by-date')) {
            return $error;
        }
        $user_id = $request->get('user_id');
        $form_date = $request->get('form_date');
        $to_date = $request->get('to_date');

        $employeeInfo = EmployeeInfo::where('user_id', $user_id)->first(['employee_main_cat_id','job_loc']);
        $authorInfo = User::where('id', $user_id)->first(['name','phone','address','tmm_so_id']);
        $reports = Account::where('user_id', $user_id)->whereBetween('date', [$form_date,$to_date])->get();
        if ($authorInfo=='') {
            alert()->error('Alert', 'No data here.');
            return redirect()->back();
        }
        return view('admin.author_ledger_book.ind_date_ledger_book', compact('authorInfo', 'reports', 'form_date', 'to_date', 'employeeInfo'));
    }

    // Ledger Book All
    public function showInvoiceAll($user_id)
    {
        if ($error = $this->authorize('author-ledger-book-show-all')) {
            return $error;
        }
        $employeeInfo = EmployeeInfo::where('user_id', $user_id)->first(['employee_main_cat_id','job_loc']);
        $authorInfo = User::where('id', $user_id)->first(['name','phone','address','tmm_so_id']);
        $reports = Account::where('user_id', $user_id)->get();
        if ($authorInfo=='') {
            alert()->error('Alert', 'No data here.');
            return redirect()->back();
        }
        return view('admin.author_ledger_book.ind_all_ledger_book', compact('authorInfo', 'reports', 'employeeInfo'));
    }
}
