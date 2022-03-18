<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\OfficeExpenseCat;
use Illuminate\Http\Request;

class OfficeExpenseCatController extends Controller
{
    public function index()
    {
        $officeExpenses = OfficeExpenseCat::whereType(1)->whereParent_id(0)->get();
        return view('admin.office_expense.office_expense_cat.index', compact('officeExpenses'));
    }

    public function store(Request $request)
    {
        $data = $this->validate($request, [
            'name' => 'required',
        ]);
        $data['type'] = 1;

        try {
            OfficeExpenseCat::create($data);
            toast('Success', 'success');
            return redirect()->back();
        } catch (\Exception $ex) {
            toast('Failed', 'error');
            return redirect()->back();
        }
    }

    public function subCatStore(Request $request)
    {
        $data = $this->validate($request, [
            'parent_id' => 'required',
            'name' => 'required',
        ]);
        $data['type'] = 1;

        try {
            OfficeExpenseCat::create($data);
            toast('Success', 'success');
            return redirect()->back();
        } catch (\Exception $ex) {
            toast('Failed', 'error');
            return redirect()->back();
        }
    }

    public function update(Request $request, $id)
    {
        $data = $this->validate($request, [
            'name' => 'required',
        ]);

        try {
            OfficeExpenseCat::find($id)->update($data);
            toast('Success', 'success');
            return redirect()->back();
        } catch (\Exception $ex) {
            toast('Failed', 'error');
            return redirect()->back();
        }
    }

    public function subCatEdit(Request $request, $id)
    {
        $data = $this->validate($request, [
            'name' => 'required',
        ]);

        $parent_id = preg_replace('/[^0-9]/', '', $request->parent_id);

        if(!empty($parent_id)){
            $data['parent_id'] = $request->parent_id;
        }
        // return $data;

        try {
            OfficeExpenseCat::find($id)->update($data);
            toast('Success', 'success');
            return redirect()->back();
        } catch (\Exception $ex) {
            toast('Failed', 'error');
            return redirect()->back();
        }
    }

    public function destroy($id)
    {
        if ($error = $this->sendPermissionError('delete')) {
            return $error;
        }
        OfficeExpenseCat::find($id)->delete();
        toast('Successfully Deleted', 'success');
        return redirect()->back();
    }
}
