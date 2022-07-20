<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\BankList;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class BankListController extends Controller
{
    public function index()
    {
        if ($error = $this->authorize('bank-list-manage')) {
            return $error;
        }
        $bankLists = BankList::all();
        return view('admin.bank_list.index', compact('bankLists'));
    }

    public function create()
    {
        if ($error = $this->authorize('bank-list-add')) {
            return $error;
        }
        return view('admin.bank_list.create');
    }

    public function store(Request $request)
    {
        if ($error = $this->authorize('bank-list-add')) {
            return $error;
        }
        $data = $this->validate($request, [
            'name' => 'required|string',
        ]);

        try {
            BankList::create($data);
            toast('Bank Successfully Inserted', 'success');
            return redirect()->route('bank-list.index');
        } catch (\Exception $ex) {
            toast($ex->getMessage().'Bank Inserted Failed', 'error');
            return back();
        }
    }

    public function edit($id)
    {
        if ($error = $this->authorize('bank-list-edit')) {
            return $error;
        }
        $bankList = BankList::find($id);
        return view('admin.bank_list.edit', compact('bankList'));
    }

    public function update(Request $request, $id)
    {
        if ($error = $this->authorize('bank-list-edit')) {
            return $error;
        }
        $data = $this->validate($request, [
            'name' => 'required|string',
        ]);

        try {
            BankList::find($id)->update($data);
            toast('Bank Successfully Updated', 'success');
            return redirect()->route('bank-list.index');
        } catch (\Exception $ex) {
            toast($ex->getMessage().'Bank Updated Failed', 'error');
            return back();
        }
    }

    public function destroy($id)
    {
        if ($error = $this->authorize('bank-list-delete')) {
            return $error;
        }
        try{
            BankList::find($id)->delete();
            Alert::success('Success','Successfully Deleted');
            return redirect()->back();
        }catch (\Exception $ex) {
            Alert::error('Oops...','Delete Failed');
            return back();
        }

    }
}
