<?php

namespace App\Http\Controllers\Backend;

use App\Models\User;
use App\Models\Account;
use App\Models\BankList;
use App\Models\UserBankAc;
use App\Models\CompanyInfo;
use App\Models\SalesReport;
use App\Models\EmployeeInfo;
use Illuminate\Http\Request;
use App\Models\SalesLedgerBook;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use RealRashid\SweetAlert\Facades\Alert;

class AccountReceivedController extends Controller
{
    public function index()
    {
        $users = User::whereIn('role', [1,2,5])->where('name', '!=', 'Developer')->orderby('business_name')->get(['id','name','phone','address','business_name','role']);
        return view('admin.account.received.index', compact('users'));
    }

    public function createId($id)
    {
        if ($error = $this->sendPermissionError('create')) {
            return $error;
        }
        // $tmmSoIds = EmployeeInfo::with(['user' => fn ($q) => $q->select(['id','tmm_so_id','name'])])->whereIn('employee_main_cat_id',[12,13])->get(['user_id']);
        $tmmSoIds = User::select(['id','tmm_so_id','name'])->whereIn('role',[1,5])->where('name', '!=', 'Developer')->get();
        $bankLists = BankList::all();
        $user = User::select(['id','name','business_name','phone','address'])->find($id);
        $invNos = SalesLedgerBook::where('customer_id', $id)->whereIn('type', [1,3,7,16,18,25])->where('c_status', 0)->where('inv_cancel', 0)->orderby('invoice_no', 'DESC')->get(['id','invoice_no']);
        return view('admin.account.received.create', compact('user', 'tmmSoIds', 'bankLists', 'invNos'));
    }


    public function store(Request $request)
    {
        $this->validate($request, [
            'sales_amt' => 'nullable|numeric',
            'credit' => 'numeric',
            'discount' => 'nullable|numeric',
            'discount_amt' => 'nullable|numeric',
        ]);

        $customer_id = $request->get('customer_id');
        $tmm_so_id = $request->get('tmm_so_id');
        $user_bank_ac_id = $request->get('user_bank_ac_id');
        $transaction_id = transaction_id('REC');

        DB::beginTransaction();

        $account = [
            'tran_id' => $transaction_id,
            'user_id' => $customer_id,
            'tmm_so_id' => $tmm_so_id,
            'ac_type' => 2,
            'trn_type' => 2, // Rec
            // 'pay_type' => $request->pay_type, // Rec
            'pay_type' => empty($request->pay_type) ? 3 : $request->pay_type,
            'payment_by' => $request->get('payment_by'),
            'user_bank_ac_id' => $user_bank_ac_id,
            'm_r_date' => $request->get('m_r_date'),
            'm_r_no' => $request->get('m_r_no'),
            'note' => $request->get('note'),
            'credit' => round($request->get('credit')),
            'date' => $request->get('date'),
            'cheque_no' => $request->get('cheque_no'),
        ];

        if (!$user_bank_ac_id) {
            $account['type'] = 1; // Cash
        } else {
            $account['type'] = 2; // Bank
        }

        $account = Account::create($account);

        $ledgerBook = [
            'tran_id' => $transaction_id,
            'user_id' => $tmm_so_id,
            'customer_id' => $customer_id,
            'invoice_no' => $request->invoice_no,
            'prepared_id' => auth()->user()->id,
            'account_id' => $account->id,
            'type' => 25, // Received
            'pay_type' => empty($request->pay_type) ? 3 : $request->pay_type,
            'invoice_date' => $request->get('date'),
            'payment' => round($request->get('credit')),
            'payment_date' => $request->get('date'),
            'c_status' => 2,
            'discount' => $request->discount,
            'discount_amt' => round($request->discount_amt),
        ];
        SalesLedgerBook::create($ledgerBook);

        // Complete Status
        if (($request->net_amt == null) && ($request->credit >= $request->due_amt)) {
            $c_status = 1;
        } elseif (!empty($request->net_amt) && ($request->credit >= $request->net_amt) || ($request->credit == 0 && $request->net_amt == 0)) {
            $c_status = 1;
        } else {
            $c_status = 0;
        }

        $ledger = SalesLedgerBook::where('invoice_no', $request->invoice_no)->get();
        $ledgerBookUpdate['c_status'] = $c_status;
        if ($request->net_amt!=null) {
            $ledgerBookUpdate['net_amt'] = $ledger->sum('sales_amt') - ($request->discount_amt + $ledger->sum('discount_amt'));
        }
        SalesLedgerBook::where('type', '!=', 25)->where('invoice_no', $request->invoice_no)->update($ledgerBookUpdate);


        $salesReport = SalesReport::where('user_id', $tmm_so_id)->first();
        if (!empty($salesReport->user_id)) {
            $report = [
                'tran_id' => $transaction_id,
                'user_id' => $salesReport->user_id,
                'type' => 2,
                // 'inv_type' => $request->type,
                'pay_type' => empty($request->pay_type) ? 3 : $request->pay_type,
                'inv_type' => empty($request->type) ? 3 : $request->type,
                'zsm_id' => $salesReport->zsm_id,
                'sso_id' => $salesReport->sso_id,
                'so_id' => $salesReport->so_id,
                'customer_id' => $customer_id,
                'invoice_date' => $request->date,
                'discount' => $request->discount,
                'discount_amt' =>  $request->discount_amt,
                'amt' => round($request->credit),
            ];
            SalesReport::create($report);
        }

        try {
            if((CompanyInfo::whereId(1)->first('sms_service')->sms_service == 1) && (env('SMS_API') != "")){
                $salesLedger = SalesLedgerBook::whereCustomer_id($customer_id);
                $collection = Account::whereUser_id($customer_id)->sum('credit');
                $du = $salesLedger->whereIn('type',[1,3,16,18])->sum('net_amt') - ($salesLedger->whereIn('type',[2,4,17,19])->sum('net_amt') + $collection);
                $customerPhone = User::find($customer_id)->phone;
                $iNo = !empty($request->invoice_no) ? $request->invoice_no:'';
                $cr = round($request->credit);
                $cNa = CompanyInfo::whereId(1)->first('name')->name;
                $msg = "Collection: Dear customer your account has been credited by ".$cr." BDT for invoice no: ".$iNo." Current due: ".$du. $cNa." BDT.";
                sms($customerPhone, $msg);
            }
            DB::commit();
            toast('Collection Successfully Inserted', 'success');
            // return redirect()->route('account-received.index');
            return back();
        } catch (\Exception $ex) {
            DB::rollBack();
            toast('Collection Inserted Failed', 'error');
            return back();
        }
    }

    public function show($userId)
    {
        $accounts = Account::whereUser_id($userId)->whereTrn_type(2)->get();
        return view('admin.account.received.show', compact('accounts'));
    }

    public function destroy($tranId)
    {
        if ($error = $this->sendPermissionError('delete')) {
            return $error;
        }
        if($tranId == 0){
            Alert::info('This is old data you can not delete this data.');
            return back();
        }
        // Ledger invoice net amount update
        $findLedgerData = SalesLedgerBook::whereTran_id($tranId)->first(['invoice_no','discount_amt']);
        $ledgerData = SalesLedgerBook::whereInvoice_no($findLedgerData->invoice_no)->whereType(1)->first(['id','net_amt']);
        SalesLedgerBook::find($ledgerData->id)->update(['net_amt' => $findLedgerData->discount_amt + $ledgerData->net_amt]);

        try{
            Account::whereTran_id($tranId)->delete();
            SalesLedgerBook::whereTran_id($tranId)->delete();
            SalesReport::whereTran_id($tranId)->delete();
            toast('Success!','success');
            return back();
        }catch(\Exception $e){
            return $e->getMessage();
            toast('Failed!','error');
            return back();
        }
    }

    public function bankInfo(Request $request)
    {
        $bank_id = $request->bank_id;
        $bankInfos = UserBankAc::where('bank_list_id', $bank_id)->get();
        $bank = '';
        $bank .= '<option selected value disable>Select</option>';
        foreach ($bankInfos as $bankInfo) {
            $bank .= '<option value="'.$bankInfo->id.'">'.$bankInfo->ac_no.'</option>';
        }
        return json_encode(['bank'=>$bank]);
    }

    public function salesInvInfo(Request $request)
    {
        $invoice_no = $request->invoice_no;
        $salesLedgers = SalesLedgerBook::where('invoice_no', $invoice_no)->get();
        $sales_amt = round($salesLedgers->where('type', '!=', 25)->first()->sales_amt);
        $net_amt = round($salesLedgers->where('type', '!=', 25)->first()->net_amt);
        $payment =  round($salesLedgers->where('type', 25)->sum('payment'));
        $type =  $salesLedgers->where('type', '!=', 25)->first()->type;

        return json_encode(['sales_amt'=>$sales_amt, 'net_amt'=>$net_amt, 'payment'=>$payment, 'type'=>$type]);
    }

    public function trash()
    {
        $accounts = Account::with('users')->onlyTrashed()->orderBy('updated_at', 'DESC')->whereTrn_type(2)->get();
        return view('admin.account.received.trash', compact('accounts'));
    }
}
