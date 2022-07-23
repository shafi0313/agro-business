<?php

namespace App\Http\Controllers\Backend;

use App\Models\User;
use App\Models\Account;
use App\Models\BankList;
use Illuminate\Http\Request;
use App\Models\OfficeExpenseCat;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class OfficeIncomeController extends Controller
{
    public function create()
    {
        if ($error = $this->authorize('income-add')) {
            return $error;
        }
        $tmmSoIds = User::select(['id','tmm_so_id','name'])->where('role', 1)->where('name', '!=', 'Developer')->orWhere('role', 5)->get();
        $officeIncomes = OfficeExpenseCat::whereType(2)->whereParent_id(0)->get();
        $bankLists = BankList::all();
        return view('admin.office_income.income.create', compact('officeIncomes', 'tmmSoIds', 'bankLists'));
    }

    public function store(Request $request)
    {
        if ($error = $this->authorize('income-add')) {
            return $error;
        }
        DB::beginTransaction();
        $user_bank_ac_id = $request->user_bank_ac_id;
        $account = [
            'tmm_so_id' => $request->tmm_so_id,
            'office_expense_cat_id' => $request->office_expense_cat_id,
            'ac_type' => 2, // Credit
            'trn_type' => 2, // Received
            'exp_type' => $request->exp_type,
            'm_r_date' => $request->get('m_r_date'),
            'm_r_no' => $request->get('m_r_no'),
            'note' => $request->get('note'),
            'credit' => $request->get('credit'),
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
    public function incomeCat(Request $request)
    {
        $incomeCats = OfficeExpenseCat::where('type', 2)->whereParent_id($request->in_type)->get();
        $inName = '';
        $inName .= '<option value="0">Select</option>';
        foreach ($incomeCats as $sub) {
            $inName .= '<option value="'.$sub->id.'">'.$sub->name.'</option>';
        }
        return json_encode(['inName'=>$inName]);
    }
}
