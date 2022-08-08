<?php

namespace App\Http\Controllers\Backend;

use App\Models\User;
use App\Models\Account;
use App\Models\BankList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class WithdrawDepositController extends Controller
{
    // Deposit _____________________________________________
    public function dCreate()
    {
        if ($error = $this->authorize('deposit-add')) {
            return $error;
        }
        $totalCashCredit = Account::where('type', 1)->sum('credit') - Account::where('type', 1)->sum('debit');
        $bankLists = BankList::all();
        $tmmSoIds = User::select(['id','tmm_so_id','name'])->where('role', 1)->where('name', '!=', 'Developer')->orwhere('role', 5)->get();
        return view('admin.account.deposit.create', compact('bankLists', 'tmmSoIds', 'totalCashCredit'));
    }

    public function dStore(Request $request)
    {
        if ($error = $this->authorize('deposit-add')) {
            return $error;
        }
        $this->validate($request, [
            'user_bank_ac_id' => 'required',
            'tmm_so_id' => 'required',
            'credit' => 'required|numeric',
            'date' => 'required|date',
        ]);

        DB::beginTransaction();


        // Cash
        $account = [
            'user_id' => null,
            'tmm_so_id' => $request->tmm_so_id,
            'type' => 1, // Cash
            'ac_type' => 1, // Debit
            'trn_type' => 1, // Payment
            'user_bank_ac_id' => $request->get('user_bank_ac_id'),
            'm_r_date' => $request->get('m_r_date'),
            // 'm_r_no' => $request->get('m_r_no'),
            'note' => $request->get('note'),
            'debit' => $request->get('credit'),
            'cheque_no' => $request->get('cheque_no'),
            'date' => $request->get('date'),
        ];
        $account = Account::create($account);

        // Bank
        $account = [
            'user_id' => null,
            'tmm_so_id' => $request->tmm_so_id,
            'type' => 2, // Bank
            'ac_type' => 2, // Credit
            'trn_type' => 2, // Receive
            'user_bank_ac_id' => $request->get('user_bank_ac_id'),
            'm_r_date' => $request->get('m_r_date'),
            // 'm_r_no' => $request->get('m_r_no'),
            'note' => $request->get('note'),
            'credit' => $request->get('credit'),
            'cheque_no' => $request->get('cheque_no'),
            'date' => $request->get('date'),
        ];
        $account = Account::create($account);

        try {
            DB::commit();
            toast('Success', 'success');
            return redirect()->back();
        } catch (\Exception $ex) {
            DB::rollBack();
            toast($ex->getMessage().'Inserted Failed', 'error');
            return back();
        }
    }

    // Withdraw ____________________________________________________________
    public function wCreate()
    {
        if ($error = $this->authorize('withdraw-add')) {
            return $error;
        }
        $bankLists = BankList::all();
        $tmmSoIds = User::select(['id','tmm_so_id','name'])->where('role', 1)->where('name', '!=', 'Developer')->orwhere('role', 5)->get();
        return view('admin.account.withdraw.create', compact('bankLists', 'tmmSoIds'));
    }

    public function wStore(Request $request)
    {
        if ($error = $this->authorize('withdraw-add')) {
            return $error;
        }
        $this->validate($request, [
            'user_bank_ac_id' => 'required',
            'tmm_so_id' => 'required',
            'debit' => 'required|numeric',
            'date' => 'required|date',
        ]);

        DB::beginTransaction();

        // Bank
        $account = [
            'user_id' => null,
            'tmm_so_id' => $request->tmm_so_id,
            'type' => 2, // Bank
            'ac_type' => 1, // Debit
            'trn_type' => 1, // Payment
            'user_bank_ac_id' => $request->get('user_bank_ac_id'),
            'm_r_date' => $request->get('m_r_date'),
            // 'm_r_no' => $request->get('m_r_no'),
            'note' => $request->get('note'),
            'debit' => $request->get('debit'),
            'cheque_no' => $request->get('cheque_no'),
            'date' => $request->get('date'),
        ];
        $account = Account::create($account);

        // Cash
        $account = [
            'user_id' => null,
            'tmm_so_id' => $request->tmm_so_id,
            'type' => 1, // Cash
            'ac_type' => 2, // Credit
            'trn_type' => 2, // Receive
            'user_bank_ac_id' => $request->get('user_bank_ac_id'),
            'm_r_date' => $request->get('m_r_date'),
            // 'm_r_no' => $request->get('m_r_no'),
            'note' => $request->get('note'),
            'credit' => $request->get('debit'),
            'cheque_no' => $request->get('cheque_no'),
            'date' => $request->get('date'),
        ];
        $account = Account::create($account);

        try {
            DB::commit();
            toast('Payment Successfully Inserted', 'success');
            return redirect()->back();
        } catch (\Exception $ex) {
            DB::rollBack();
            toast($ex->getMessage().'Payment Inserted Failed', 'error');
            return back();
        }
    }
}
