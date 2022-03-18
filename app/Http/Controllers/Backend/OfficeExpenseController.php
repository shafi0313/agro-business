<?php

namespace App\Http\Controllers\Backend;

use App\Models\User;
use App\Models\Account;
use App\Models\BankList;
use Illuminate\Http\Request;
use App\Models\OfficeExpenseCat;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class OfficeExpenseController extends Controller
{
    public function create()
    {
        $totalCashCredit = Account::where('type', 1)->sum('credit') - Account::where('type', 1)->sum('debit');
        $tmmSoIds = User::select(['id','tmm_so_id','name'])->where('role', 1)->where('name', '!=', 'Developer')->orwhere('role', 5)->get();
        $officeExpenseCats = OfficeExpenseCat::whereType(1)->whereParent_id(0)->get();
        $bankLists = BankList::all();
        return view('admin.office_expense.office_expense.create', compact('officeExpenseCats', 'tmmSoIds', 'totalCashCredit', 'bankLists'));
    }

    public function store(Request $request)
    {
        DB::beginTransaction();

        $user_bank_ac_id = $request->user_bank_ac_id;
        $account = [
            'tmm_so_id' => $request->tmm_so_id,
            'office_expense_cat_id' => $request->office_expense_cat_id,
            'ac_type' => 1, // Payment Debit
            'trn_type' => 1, // Payment
            'exp_type' => $request->exp_type,
            'm_r_date' => $request->get('m_r_date'),
            'm_r_no' => $request->get('m_r_no'),
            'note' => $request->get('note'),
            'debit' => round($request->get('debit')),
            'cheque_no' => $request->get('cheque_no'),
            'date' => $request->get('date'),
        ];

        if ($user_bank_ac_id) {
            $account['type'] = 2;
            $account['user_bank_ac_id'] = $user_bank_ac_id;
        } else {
            $account['type'] = 1;
        }

        try {
            $account = Account::create($account);
            DB::commit();
            toast('Success', 'success');
            return redirect()->back();
        } catch (\Exception $ex) {
            DB::rollBack();
            toast('Failed', 'error');
            return back();
        }
    }

    // Expense category
    public function expenseCat(Request $request)
    {
        $expenseCats = OfficeExpenseCat::where('type', 1)->whereParent_id($request->exp_type)->get();
        $expName = '';
        $expName .= '<option value="0">Select</option>';
        foreach ($expenseCats as $sub) {
            $expName .= '<option value="'.$sub->id.'">'.$sub->name.'</option>';
        }
        return json_encode(['expName'=>$expName]);
    }
}
