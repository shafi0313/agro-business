<?php

namespace App\Http\Controllers\Backend;

use App\Models\SalesReport;
use App\Models\EmployeeInfo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SalesReportController extends Controller
{
    public function userCash()
    {
        if ($error = $this->authorize('employee-report-manage')) {
            return $error;
        }
        $users = EmployeeInfo::where('employee_main_cat_id',11)->orwhere('employee_main_cat_id', 12)->orwhere('employee_main_cat_id', 13)->orderby('employee_main_cat_id','ASC')->get();
        return view('admin.sales_report.cash.index', compact('users'));
    }

    public function selectDateCash($id)
    {
        $user = EmployeeInfo::find($id);
        return view('admin.sales_report.cash.select_date', compact('user'));
    }

    public function showReportCash(Request $request)
    {
        if ($error = $this->authorize('employee-report-show')) {
            return $error;
        }
        $form_date = $request->get('form_date');
        $to_date = $request->get('to_date');
        $user_id = $request->get('user_id');
        $emp_id = $request->get('emp_id');

        if($emp_id==11){
            $reports = SalesReport::whereBetween('invoice_date',[$form_date,$to_date])->where('zsm_id', $user_id)->get();
            // $reports = $getReports->groupby('zsm_id');
            return view('admin.sales_report.cash.zsm', compact('reports'));
        }else if($emp_id==12){
            $reports = SalesReport::whereBetween('invoice_date',[$form_date,$to_date])->where('sso_id', $user_id)->get();
            // $reports = $getReports->groupby('sso_id');
            return view('admin.sales_report.cash.sso', compact('reports'));
        }else if($emp_id==13){
            $reports = SalesReport::whereBetween('invoice_date',[$form_date,$to_date])->where('user_id', $user_id)->get();
            return view('admin.sales_report.cash.so', compact('reports'));
        }
    }

    public function userCredit()
    {
        // if ($error = $this->authorize('employee-report-show')) {
        //     return $error;
        // }
        $users = EmployeeInfo::where('employee_main_cat_id',11)->orwhere('employee_main_cat_id', 12)->orwhere('employee_main_cat_id', 13)->get();
        return view('admin.sales_report.credit.index', compact('users'));
    }

    public function selectDateCredit($id)
    {
        $user = EmployeeInfo::find($id);
        return view('admin.sales_report.credit.select_date', compact('user'));
    }

    public function showReportCredit(Request $request)
    {
        $form_date = $request->get('form_date');
        $to_date = $request->get('to_date');
        $user_id = $request->get('user_id');
        $emp_id = $request->get('emp_id');

        if($emp_id==11){
            $getReports = SalesReport::whereBetween('invoice_date',[$form_date,$to_date])->where('zsm_id', $user_id)->where('inv_type',3)->get();
            $reports = $getReports->groupby('zsm_id');
            return view('admin.sales_report.credit.zsm', compact('reports'));
        }else if($emp_id==12){
            $getReports = SalesReport::whereBetween('invoice_date',[$form_date,$to_date])->where('sso_id', $user_id)->where('inv_type',3)->get();
            $reports = $getReports->groupby('sso_id');
            return view('admin.sales_report.credit.sso', compact('reports'));
        }else if($emp_id==13){
            $getReports = SalesReport::whereBetween('invoice_date',[$form_date,$to_date])->where('user_id', $user_id)->where('inv_type',3)->get();
            $reports = $getReports->groupby('user_id');
            return view('admin.sales_report.credit.so', compact('reports'));
        }
    }
}
