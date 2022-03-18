<?php

namespace App\Http\Controllers\Backend;

use App\Models\ProductCat;
use Illuminate\Http\Request;
use App\Models\EmployeeMainCat;
use App\Http\Controllers\Controller;

class EmployeeMainController extends Controller
{
    public function index()
    {
        $employeeMainCats = EmployeeMainCat::all();
        return view('admin.employee_main_cat.index', compact('employeeMainCats'));
    }

    public function store(Request $request)
    {
        if ($error = $this->sendPermissionError('create')) {
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
        if ($error = $this->sendPermissionError('edit')) {
            return $error;
        }
        $employeeMainCat = EmployeeMainCat::find($id);
        return view('admin.product_cat.edit', compact('employeeMainCat'));
    }

    public function update(Request $request, $id)
    {
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
        if ($error = $this->sendPermissionError('delete')) {
            return $error;
        }
        ProductCat::find($id)->delete();
        toast('Successfully Deleted', 'success');
        return redirect()->back();
    }
}
