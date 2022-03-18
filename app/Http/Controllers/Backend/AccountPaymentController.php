<?php

namespace App\Http\Controllers\Backend;

use App\Models\User;
use App\Models\Account;
use App\Models\BankList;
use Illuminate\Http\Request;
use App\Models\PurchaseLedgerBook;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class AccountPaymentController extends Controller
{
    public function index()
    {
        $users = User::select(['id','name','phone','address','business_name','role'])->where('role', 1)->where('name','!=','Developer')->orWhere('role', 3)->orWhere('role', 5)->orderBy('name')->get();
        return view('admin.account.payment.index', compact('users'));
    }

    public function createId($id)
    {
        if ($error = $this->sendPermissionError('create')) {
            return $error;
        }
        $totalCashCredit = Account::where('type', 1)->sum('credit') - Account::where('type', 1)->sum('debit');
        $bankLists = BankList::all();
        $user = User::select(['id','name','phone','address','business_name'])->find($id);
        $tmmSoIds = User::select(['id','tmm_so_id','name'])->where('role',1)->where('name','!=','Developer')->orwhere('role',5)->get();

        return view('admin.account.payment.create', compact('user','bankLists','tmmSoIds','totalCashCredit'));
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'date' => 'required|date',
            'chequeco_no' => 'nullable|numeric',
        ]);

        $supplier_id = $request->get('supplier_id');
        $tmm_so_id = $request->get('tmm_so_id');
        $user_bank_ac_id = $request->get('user_bank_ac_id');
        $transaction_id = transaction_id('PAY');

        DB::beginTransaction();
        $account = [
            'tran_id' => $transaction_id,
            'user_id' => $supplier_id,
            'tmm_so_id' => $request->tmm_so_id,
            'ac_type' => 1, // Payment
            'trn_type' => 1, // Payment
            'payment_by' => $request->get('payment_by'),
            'user_bank_ac_id' => $user_bank_ac_id,
            'm_r_date' => $request->get('m_r_date'),
            'm_r_no' => $request->get('m_r_no'),
            'note' => $request->get('note'),
            'debit' => round($request->get('debit')),
            'cheque_no' => $request->get('cheque_no'),
            'date' => $request->get('date'),
        ];

        if(!$user_bank_ac_id){
            $account['type'] = 1; // Cash
        }else{
            $account['type'] = 2; // Bank
        }


        $account = Account::create($account);

        $ledgerBook = [
            'tran_id' => $transaction_id,
            'user_id' =>  $tmm_so_id,
            'supplier_id' =>  $supplier_id,
            'prepared_id' => auth()->user()->id,
            'account_id' => $account->id,
            'type' => 26, // Payment
            'invoice_date' => $request->get('date'),
            'payment' => round($request->get('debit')),
            'payment_date' => $request->get('date'),
        ];

        try{
            PurchaseLedgerBook::create($ledgerBook);
            DB::commit();
            toast('Payment Successfully Inserted','success');
            return redirect()->back();
        } catch (\Exception $ex) {
            DB::rollBack();
            toast($ex->getMessage().'Payment Inserted Failed','error');
            return back();
        }
    }

    public function bankBalance(Request $request)
    {
        $ac_no_id = $request->ac_no_id;
        $bankAcBalances = Account::where('user_bank_ac_id', $ac_no_id)->where('type',2)->get();
        $amt = '';
        $amt .= $bankAcBalances->sum('credit') - $bankAcBalances->sum('debit');
        return json_encode(['amt'=>$amt]);
    }
}
