<?php

namespace App\Http\Controllers\Backend;

use App\Models\SalesReport;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\EmployeeInfo;

class CollectionReportController extends Controller
{
    public function user()
    {
        $users = EmployeeInfo::where('employee_main_cat_id', 11)->orWhere('employee_main_cat_id', 12)->orWhere('employee_main_cat_id', 13)->get();
        return view('admin.emp_collection_report.index', compact('users'));
    }

    public function selectDate($id)
    {
        $user = EmployeeInfo::find($id);
        return view('admin.emp_collection_report.select_date', compact('user'));
    }

    public function showReport(Request $request)
    {
        $form_date = $request->get('form_date');
        $to_date = $request->get('to_date');
        $user_id = $request->get('user_id');
        $emp_id = $request->get('emp_id');

        if ($emp_id==11) {
            $getReports = SalesReport::whereBetween('invoice_date', [$form_date,$to_date])->where('zsm_id', $user_id)->where('type', 2)->get();
            $reports = $getReports->groupBy('zsm_id');
            return view('admin.emp_collection_report.zsm', compact('reports'));
        } elseif ($emp_id==12) {
            $getReports = SalesReport::whereBetween('invoice_date', [$form_date,$to_date])->where('sso_id', $user_id)->where('type', 2)->get();
            $reports = $getReports->groupBy('sso_id');
            return view('admin.emp_collection_report.sso', compact('reports'));
        } elseif ($emp_id==13) {
            $getReports = SalesReport::whereBetween('invoice_date', [$form_date,$to_date])->where('user_id', $user_id)->where('type', 2)->get();
            $reports = $getReports->groupBy('user_id');
            return view('admin.emp_collection_report.so', compact('reports'));
        }
    }
}
