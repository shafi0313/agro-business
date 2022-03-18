<?php

namespace App\Http\Controllers\Backend;

use App\Models\User;
use App\Models\EmployeeCat;
use App\Models\EmployeeInfo;
use Illuminate\Http\Request;
use App\Models\EmployeeMainCat;
use App\Http\Controllers\Controller;

class EmployeeCatController extends Controller
{
    public function index()
    {
        return view('admin.emp_cat.index');
    }

    public function create()
    {
        if ($error = $this->sendPermissionError('create')) {
            return $error;
        }
        $users = User::where('role', 5)->get();
        $em = EmployeeMainCat::all();
        $allEm = EmployeeCat::with('sub')->where('parent_id', 0)->get();
        return view('admin.emp_cat.create', compact('users', 'em', 'allEm'));
    }

    public function mainStore(Request $request)
    {
        if ($error = $this->sendPermissionError('create')) {
            return $error;
        }
        $date=[
            'user_id' => $request->user_id,
            'employee_main_cat_id' => $request->employee_main_cat_id,
            'parent_id' => 0,
        ];

        try {
            EmployeeCat::create($date);
            toast('Success', 'success');
            return redirect()->back();
        } catch (\Exception $ex) {
            toast('Error', 'Error');
            return redirect()->back();
        }
    }

    public function subStore(Request $request)
    {
        if ($error = $this->sendPermissionError('create')) {
            return $error;
        }
        $date=[
            'user_id' => $request->user_id,
            'employee_main_cat_id' => $request->employee_main_cat_id,
            'parent_id' => $request->parent_id,
        ];

        try {
            EmployeeCat::create($date);
            toast('Success', 'success');
            return redirect()->back();
        } catch (\Exception $ex) {
            toast('Error', 'Error');
            return redirect()->back();
        }
    }

    public function getEmp(Request $request)
    {
        $employee_main_cat_id = $request->employee_main_cat_id;
        $empDesignation = EmployeeCat::where('employee_main_cat_id', $employee_main_cat_id)->get();
        $emp = '';
        $emp .= '<option selected value disable>Select</option>';
        foreach ($empDesignation as $sub) {
            $emp .= '<option value="'.$sub->id.'">'.$sub->user->name.'</option>';
        }
        return json_encode(['emp'=>$emp]);
    }

    public function getAllEmp(Request $request)
    {
        $officer_id = $request->officer_id;
        $allEmps = User::where('role', 5)->get();
        $allEmp = '';
        $allEmp .= '<option selected value disable>Select</option>';
        foreach ($allEmps as $sub) {
            $allEmp .= '<option value="'.$sub->id.'">'.$sub->name.'</option>';
        }
        return json_encode(['allEmp'=>$allEmp]);
    }
}
