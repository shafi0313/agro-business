<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\BankList;
use Illuminate\Http\Request;

class BankListController extends Controller
{
    public function index()
    {
        $bankLists = BankList::all();
        return view('admin.bank_list.index', compact('bankLists'));
    }

    public function create()
    {
        if ($error = $this->sendPermissionError('create')) {
            return $error;
        }
        return view('admin.bank_list.create');
    }

    public function store(Request $request)
    {
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
        if ($error = $this->sendPermissionError('edit')) {
            return $error;
        }
        $bankList = BankList::find($id);
        return view('admin.bank_list.edit', compact('bankList'));
    }

    public function update(Request $request, $id)
    {
        $data = $this->validate($request, [
            'name' => 'required|string',
        ]);

        try {
            BankList::find($id)->update($data);
            toast('Bank Successfully Updated', 'success');
            return redirect()->route('bank-list.index');
        } catch (\Exception $ex) {
            toast($ex->getMessage().'Bank Updated Faild', 'error');
            return back();
        }
    }

    public function destroy($id)
    {
        if ($error = $this->sendPermissionError('delete')) {
            return $error;
        }
        BankList::find($id)->delete();
        toast('Product Size Successfully Inserted', 'success');
        return redirect()->back();
    }
}
