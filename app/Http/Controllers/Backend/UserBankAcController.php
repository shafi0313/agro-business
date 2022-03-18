<?php

namespace App\Http\Controllers\Backend;

use App\Models\User;
use App\Models\Account;
use App\Models\BankList;
use App\Models\UserBankAc;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class UserBankAcController extends Controller
{
    public function index()
    {
        $userBankAcs = UserBankAc::all();
        return view('admin.user_bank_ac.index', compact('userBankAcs'));
    }
    public function create()
    {
        if ($error = $this->sendPermissionError('create')) {
            return $error;
        }
        $users = User::select(['id','name'])->where('role',1)->where('role',5)->orwhere('name','!=', 'Developer')->get();
        $bankLists = BankList::all();
        return view('admin.user_bank_ac.create', compact('users','bankLists'));
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        $data = $this->validate($request, [
            'user_id' => 'required',
            'bank_list_id' => 'required',
            'ac_name' => 'required|max:50',
            'ac_no' => 'required|max:50',
            'cheque_no' => 'nullable|max:50',
            // 'Previous' => 'sometimes',
            'branch' => 'required|max:100',
            'address' => 'required',
        ]);
        $userBankAc = UserBankAc::create($data);

        // For previous
        $account = [
            'user_id' => $request->user_id,
            'tmm_so_id' => NULL, // For previous
            'user_bank_ac_id' => $userBankAc->id,
            'type' => 2,
            'ac_type' => 1,
            'trn_type' => 3,
            'credit' => $request->previous,
            'note' => 'Previous',
            'cheque_no' => $request->cheque_no,
            'date' => $request->date,
        ];

        Account::create($account);
        try{
            toast('Success','success');
            DB::commit();
            return redirect()->route('user-bank-ac.index');
        }catch(\Exception $ex){
            DB::rollback();
            toast($ex->getMessage().'Failed','error');
        }
        return redirect()->back();
    }

    public function edit($id)
    {
        if ($error = $this->sendPermissionError('edit')) {
            return $error;
        }
        $userBankAc = UserBankAc::find($id);
        $users = User::select(['id','name'])->where('role',1)->where('role',5)->orwhere('name','!=', 'Developer')->get();
        $bankLists = BankList::all();

        $account = Account::where('user_id', Null)->where('user_bank_ac_id', $id)->first();
        return view('admin.user_bank_ac.edit', compact('userBankAc','users','bankLists','account'));
    }

    public function update(Request $request, $id)
    {
        // return $request;
        $data = $this->validate($request, [
            'user_id' => 'required',
            'bank_list_id' => 'required',
            'ac_name' => 'required|max:50',
            'ac_no' => 'required|max:50',
            'cheque_no' => 'nullable|max:50',
            // 'previous' => 'sometimes',
            'branch' => 'required|max:100',
            'address' => 'required',
        ]);

        // For previous
        $account = [
            'user_id' => $request->user_id,
            'tmm_so_id' => NULL, // For previous
            'user_bank_ac_id' => $id,
            'type' => 2,
            'ac_type' => 2,
            'credit' => $request->previous,
            'note' => 'Previous',
            'cheque_no' => $request->cheque_no,
            'date' => $request->date,
        ];
        Account::create($account);

        try{
            UserBankAc::find($id)->update($data);
            toast('Success','success');
            return redirect()->route('user-bank-ac.index');
        }catch(\Exception $ex){
            toast($ex->getMessage().'Failed','error');
        }
        return redirect()->back();
    }

    public function destroy($id)
    {
        if ($error = $this->sendPermissionError('delete')) {
            return $error;
        }
        UserBankAc::find($id)->delete();
        toast('Success','success');
        return redirect()->back();
    }
}
