<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Models\OfficeExpenseCat;
use App\Http\Controllers\Controller;
use RealRashid\SweetAlert\Facades\Alert;

class OfficeIncomeCatController extends Controller
{
    public function index()
    {
        if ($error = $this->authorize('office-income-category-manage')) {
            return $error;
        }
        $officeIncomeCats = OfficeExpenseCat::whereType(2)->get();
        return view('admin.office_income.income_cat.index', compact('officeIncomeCats'));
    }

    public function store(Request $request)
    {
        if ($error = $this->authorize('office-income-category-add')) {
            return $error;
        }
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
        if ($error = $this->authorize('office-income-category-add')) {
            return $error;
        }
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
        if ($error = $this->authorize('office-income-category-add')) {
            return $error;
        }
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
        if ($error = $this->authorize('office-income-category-add')) {
            return $error;
        }
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
        if ($error = $this->authorize('office-income-category-delete')) {
            return $error;
        }
        try{
            OfficeExpenseCat::find($id)->delete();
            Alert::success(__('app.success'),__('app.delete-success-message'));
            return redirect()->back();
        }catch (\Exception $ex) {
            Alert::error(__('app.oops'),__('app.delete-error-message'));
            return back();
        }
    }
}
