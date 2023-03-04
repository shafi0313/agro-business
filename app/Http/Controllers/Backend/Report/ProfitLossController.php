<?php

namespace App\Http\Controllers\Backend\Report;

use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class ProfitLossController extends Controller
{
    public function selectDate()
    {
        return view('admin.report.profit_loss.select_date');
    }
    public function show(Request $request)
    {
        // if ($error = $this->authorize('profit-loss-report')) {
        //     return $error;
        // }
        $start_date = $request->start_date;
        $end_date   = $request->end_date;

        $profitLosses = Account::
        select('*',DB::raw('DATE_FORMAT(date, "%Y-%m") as dateGroup'))
        ->whereBetween(DB::raw("(DATE_FORMAT(date,'%Y-%m'))"), [$start_date, $end_date])

        // ->selectRaw("(DATE_FORMAT(date, '%m-%Y')) as month_year")
        // ->groupBy(DB::raw("DATE_FORMAT(date, '%m-%Y')"))
        ->get();
        // ->groupBy(DB::raw("DATE_FORMAT(date, '%Y-%m')"));
        // ->groupBy(DB::raw("DATE_FORMAT(date, '%m-%Y')"));
        return view('admin.report.profit_loss.show', compact('start_date','end_date','profitLosses'));
    }
}
