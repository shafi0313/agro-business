<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Models\OfficeExpenseCat;
use App\Http\Controllers\Controller;

class OfficeIncomeCatController extends Controller
{
    public function index()
    {
        $officeIncomeCats = OfficeExpenseCat::whereType(2)->get();
        return view('admin.office_income.income_cat.index', compact('officeIncomeCats'));
    }

    public function store(Request $request)
    {
        $data = $this->validate($request, [
            'name' => 'required',
        ]);
        $data['type'] = 2;

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
        $data['type'] = 2;

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
