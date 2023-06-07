<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Models\SalesLedgerBook;
use App\Http\Controllers\Controller;
use RealRashid\SweetAlert\Facades\Alert;

class InvManuallyPayComplete extends Controller
{
    public function index(Request $request)
    {
        $invoice = SalesLedgerBook::with('customer')->where(['c_status' => 0, 'invoice_no' => $request->invoice_no, ['type', '!=', 25]])->first();
        $invoicePayment = SalesLedgerBook::where(['invoice_no' => $request->invoice_no, 'type' => 25])->sum('payment');
        if(!$invoice &&  filled($request->invoice_no)){
            Alert::info('Info','Invoice Not Found');
            return view('admin.inv_manually_pay_complete.index', compact('invoice','invoicePayment'));
        }
        return view('admin.inv_manually_pay_complete.index', compact('invoice','invoicePayment'));
        
        
    }

    public function update(Request $request)
    {
        try{
            SalesLedgerBook::find($request->invoice_id)->update(['c_status' => 1]);
            Alert::success('Success','Invoice Payment Completed Successfully');
            return back();
        }catch(\Exception $e){
            Alert::error('Error','Something Went Wrong');
            return back();
        }
    }
}
