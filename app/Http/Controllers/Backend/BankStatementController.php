<?php

namespace App\Http\Controllers\Backend;

use App\Models\Account;
use App\Models\BankList;
use App\Models\UserBankAc;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use RealRashid\SweetAlert\Facades\Alert;

class BankStatementController extends Controller
{
    public function selectDate()
    {
        if ($error = $this->authorize('bank-statement-manage')) {
            return $error;
        }
        $userBankAcs = BankList::all();
        return view('admin.account.bank_statement.select_date', compact('userBankAcs'));
    }

    public function index(Request $request)
    {
        if ($error = $this->authorize('bank-statement-manage')) {
            return $error;
        }
        $form_date = $request->get('form_date');
        $to_date = $request->get('to_date');
        $bank_id = $request->get('bank_id');
        $user_bank_ac_id = $request->get('user_bank_ac_id');
        $all_report = $request->get('all_report');

        // All Bank = -1
        // All Date = -2
        if (($bank_id == -1) && ($all_report != -2)) {
            // all bank not all date
            if (!$form_date  && !$to_date) {
                Alert::warning('Please select date');
                return redirect()->back();
            }
            $accounts = Account::with(['userBank' => function ($q) {
                $q->select('id', 'bank_list_id', 'ac_no');
            }])
                    ->where('type', 2)
                    ->whereBetween('date', [$form_date,$to_date])
                    ->get(['id','user_bank_ac_id','m_r_date','date','note','debit','credit','cheque_no']);

            $getAccountsOpen = Account::where('user_bank_ac_id', $user_bank_ac_id)->where('type', 2)->where('date', '<=', $form_date);
            $opening = $getAccountsOpen->sum('credit') - $getAccountsOpen->sum('debit');
        } elseif (($bank_id == -1) && ($all_report == -2)) {
            // all bank & all date
            $accounts = Account::with(['userBank' => function ($q) {
                $q->select('id', 'bank_list_id', 'ac_no');
            }])->where('type', 2)
                    ->get(['id','user_bank_ac_id','m_r_date','date','note','debit','credit','cheque_no']);
            $getAccountsOpen = 0;
            $opening = 0;
        } elseif (($bank_id != -1) && $all_report != -2) {
            // not all bank & not all date
            if (!$form_date  && !$to_date) {
                Alert::warning('Please select date');
                return redirect()->back();
            }
            $accounts = Account::with(['userBank' => function ($q) {
                $q->select('id', 'bank_list_id', 'ac_no');
            }])
                    ->where('user_bank_ac_id', $user_bank_ac_id)
                    ->where('type', 2)->whereBetween('date', [$form_date,$to_date])
                    ->get(['id','user_bank_ac_id','m_r_date','date','note','debit','credit','cheque_no']);

            $getAccountsOpen = Account::where('user_bank_ac_id', $user_bank_ac_id)->where('type', 2)->where('date', '<', $form_date);
            $opening = $getAccountsOpen->sum('credit') - $getAccountsOpen->sum('debit');
        } else {
            $accounts = Account::with(['userBank' => function ($q) {
                $q->select('id', 'bank_list_id', 'ac_no');
            }])
                    ->where('user_bank_ac_id', $user_bank_ac_id)
                    ->where('type', 2)->get(['id','user_bank_ac_id','m_r_date','date','note','debit','credit','cheque_no']);
            $getAccountsOpen = 0;
            $opening = 0;
        }
        if ($bank_id != -1) {
            return view('admin.account.bank_statement.single', compact('accounts', 'opening', 'form_date', 'to_date'));
        } else {
            return view('admin.account.bank_statement.all', compact('accounts', 'opening', 'form_date', 'to_date'));
        }
    }

    public function bankPreStore(Request $request)
    {
        if ($error = $this->authorize('bank-statement-previous-add')) {
            return $error;
        }

        $this->validate($request, [
            'credit' => 'required|numeric',
            'date' => 'required'
        ]);

        $account = [
            'user_id' => null,
            'tmm_so_id' => null,
            'user_bank_ac_id' => $request->user_bank_ac_id,
            'type' => 2,
            'ac_type' => 1,
            'trn_type' => 3,
            'note' => $request->get('note'),
            'credit' => $request->get('credit'),
            'date' => $request->get('date'),
        ];
        DB::beginTransaction();

        try {
            Account::create($account);
            DB::commit();
            toast('Success', 'success');
            return redirect()->back();
        } catch (\Exception $ex) {
            DB::rollBack();
            toast($ex->getMessage().'Inserted Failed', 'error');
            return redirect()->back();
        }
    }
}
