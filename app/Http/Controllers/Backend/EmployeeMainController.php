<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Models\EmployeeMainCat;
use App\Http\Controllers\Controller;
use RealRashid\SweetAlert\Facades\Alert;

class EmployeeMainController extends Controller
{
    public function index()
    {
        if ($error = $this->authorize('employee-category-manage')) {
            return $error;
        }
        $employeeMainCats = EmployeeMainCat::all();
        return view('admin.employee_main_cat.index', compact('employeeMainCats'));
    }

    public function store(Request $request)
    {
        if ($error = $this->authorize('employee-category-add')) {
            return $error;
        }
        $data = $this->validate($request, [
            'name' => 'required',
        ]);

        try {
            EmployeeMainCat::create($data);
            toast('Inserted', 'success');
            return redirect()->route('employee-main-cat.index');
        } catch (\Exception $ex) {
            toast($ex->getMessage().'Failed', 'error');
            return redirect()->back();
        }
    }

    public function edit($id)
    {
        if ($error = $this->authorize('employee-category-edit')) {
            return $error;
        }
        $employeeMainCat = EmployeeMainCat::find($id);
        return view('admin.employee_main_cat.edit', compact('employeeMainCat'));
    }

    public function update(Request $request, $id)
    {
        if ($error = $this->authorize('employee-category-edit')) {
            return $error;
        }
        $data = $this->validate($request, [
            'name' => 'required',
        ]);

        try {
            EmployeeMainCat::find($id)->update($data);
            toast('Category Successfully Update', 'success');
            return redirect()->route('employee-main-cat.index');
        } catch (\Exception $ex) {
            toast('Category Update Failed', 'error');
            return redirect()->back();
        }
    }

    public function destroy($id)
    {
        if ($error = $this->authorize('employee-category-delete')) {
            return $error;
        }
        try{
            EmployeeMainCat::find($id)->delete();
            Alert::success(__('app.success'),__('app.delete-success-message'));
            return redirect()->back();
        }catch (\Exception $ex) {
            Alert::error(__('app.oops'),__('app.delete-error-message'));
            return back();
        }
    }
}
