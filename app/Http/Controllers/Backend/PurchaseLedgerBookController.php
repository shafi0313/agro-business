<?php

namespace App\Http\Controllers\Backend;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\PurchaseInvoice;
use App\Models\PurchaseLedgerBook;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use PDF;
class PurchaseLedgerBookController extends Controller
{
    public function index()
    {
        $suppliers = user::where('role', 3)->orderBy('business_name')->get();
        return view('admin.purchase.purchase_ledger_book.index', compact('suppliers'));
    }

    public function ledgerBookSelectDate(User $supplier_id)
    {
        $supplierInfo = PurchaseInvoice::where('supplier_id', $supplier_id->id)->get();
        return view('admin.purchase.purchase_ledger_book.ind_select_date', compact('supplierInfo','supplier_id'));
    }

    // Ledger Book By Date
    public function showInvoice(Request $request)
    {
        $supplier_id = $request->get('supplier_id');
        $form_date = $request->get('form_date');
        $to_date = $request->get('to_date');

        $supplierInfo = PurchaseInvoice::where('supplier_id', $supplier_id)->first();
        $invoices = PurchaseLedgerBook::where('supplier_id',$supplier_id)
                    ->whereBetween('invoice_date',[$form_date,$to_date])
                    ->where(function($q){
                        $q->where('type', 7)
                            ->orWhere('type', 8)
                            ->orWhere('type', 13)
                            ->orWhere('type', 14)
                            ->orWhere('type', 26);
                    })
                    // ->orderBy('challan_no','DESC')
                    ->get();
        $purchaseInvoices = PurchaseLedgerBook::where('supplier_id',$supplier_id)
                    ->whereBetween('invoice_date',[$form_date,$to_date])
                    ->where('type', 7)
                    ->orWhere('type', 8)
                    ->orWhere('type', 13)
                    ->orWhere('type', 14)
                    ->orWhere('type', 25)
                    ->get();
        $payment = PurchaseLedgerBook::where('supplier_id',$supplier_id)->whereBetween('invoice_date',[$form_date,$to_date])->where('type', 25)->get();
        if($supplierInfo == ''){
            alert()->info('Alert','There are no data available.');
            return redirect()->back();
        }
        return view('admin.purchase.purchase_ledger_book.ind_date_ledger_book', compact('supplierInfo','invoices','purchaseInvoices','form_date','to_date','payment'));
    }

    // Ledger Book All
    public function indAllLedgerBook($supplier_id)
    {
        $supplierInfo = PurchaseInvoice::where('supplier_id', $supplier_id)->first();
        $openingBl = PurchaseLedgerBook::where('supplier_id',$supplier_id)->where('type',0)->first();
        $invoices = PurchaseLedgerBook::where('supplier_id',$supplier_id)
                ->where(function($q){
                    $q->where('type', 7)
                        ->orWhere('type', 8)
                        ->orWhere('type', 13)
                        ->orWhere('type', 14)
                        ->orWhere('type', 26);
                })
                // ->orderBy('challan_no','DESC')
                ->get();
        // $purchaseInvoices = PurchaseLedgerBook::where('supplier_id',$supplier_id)
        //         ->where(function($q){
        //             $q->where('type', 7)
        //                 ->orWhere('type', 8)
        //                 ->orWhere('type', 13)
        //                 ->orWhere('type', 14)
        //                 ->orWhere('type', 26);
        //         })
        //         ->get();
        $payment = PurchaseLedgerBook::where('supplier_id',$supplier_id)->where('type', 26)->get();
        if($supplierInfo == ''){
            alert()->info('Alert','There are no data available.');
            return redirect()->back();
        }

        return view('admin.purchase.purchase_ledger_book.ind_all_ledger_book', compact('supplierInfo','invoices','payment','openingBl'));
    }

    public function allShowInvoice()
    {
        $invoices = PurchaseLedgerBook::orderBy('challan_no','DESC')
                    ->where('type', 7)
                    ->orWhere('type', 8)
                    ->orWhere('type', 13)
                    ->orWhere('type', 14)
                    ->orWhere('type', 25)
                    ->get();
        $purchaseAmt = PurchaseLedgerBook::orderBy('challan_no','DESC')
                    ->where('type', 7)
                    ->orWhere('type', 8)
                    ->orWhere('type', 13)
                    ->orWhere('type', 14)
                    ->orWhere('type', 25)
                    ->get();
        $payment = PurchaseLedgerBook::where('type', 25)->get();
        return view('admin.purchase.purchase_ledger_book.all_ledger_book', compact('invoices','purchaseAmt','payment'));
    }

    // PDF Download
    // public function showInvoicePdf($supplier_id, $form_date, $to_date)
    // {
    //     $supplierInfo = PurchaseInvoice::where('supplier_id', $supplier_id)->first();
    //     $invoices = PurchaseLedgerBook::where('supplier_id',$supplier_id)->whereBetween('invoice_date',[$form_date,$to_date])->orderBy('invoice_no','DESC')->get();
    //     $purchaseInvoices = PurchaseLedgerBook::where('supplier_id',$supplier_id)->whereBetween('invoice_date',[$form_date,$to_date])->where('type', 0)->get();
    //     $returnPurchaseInvoices = PurchaseLedgerBook::where('supplier_id',$supplier_id)->whereBetween('invoice_date',[$form_date,$to_date])->where('type', 1)->get();
    //     $payment = PurchaseLedgerBook::where('supplier_id',$supplier_id)->whereBetween('invoice_date',[$form_date,$to_date])->where('type', 2)->get();

    //     $pdf = PDF::loadView('admin.purchase.purchase_ledger_book.ledger_book_pdf', compact('supplierInfo','invoices','purchaseInvoices','returnPurchaseInvoices','form_date','to_date','payment'));
    //     return $pdf->download('purchase-ledger_book_by-date.pdf');
    // }

    public function showInvoiceAllPdf($supplier_id)
    {
        // $supplierInfo = PurchaseInvoice::where('supplier_id', $supplier_id)->first();
        // $invoices = PurchaseLedgerBook::where('supplier_id',$supplier_id)->orderBy('invoice_no','DESC')->get();
        // $purchaseInvoices = PurchaseLedgerBook::where('supplier_id',$supplier_id)->where('type', 0)->get();
        // $returnPurchaseInvoices = PurchaseLedgerBook::where('supplier_id',$supplier_id)->where('type', 1)->get();
        // $payment = PurchaseLedgerBook::where('supplier_id',$supplier_id)->where('type', 2)->get();

        // $pdf = PDF::loadView('admin.purchase.purchase_ledger_book.ledger_book_all_pdf', compact('supplierInfo','invoices','purchaseInvoices','returnPurchaseInvoices','payment'));
        // return $pdf->download('purchase-ledger_book_all.pdf');
    }

    public function ledgerUpdate(Request $request, $id)
    {
        if ($error = $this->sendPermissionError('edit')) {
            return $error;
        }
        $total_amt = $request->get('total_amt');
        $payment_amt = $request->get('payment');
        $courier_pay = $request->get('courier_pay');
        $dues_amt = $total_amt -   $payment_amt - $courier_pay ;


        $data = [
            'payment' => $payment_amt,
            'courier_pay' => $courier_pay,
            'dues_amt' => $dues_amt,
            'payment_date' => Carbon::now(),
        ];


        DB::beginTransaction();
        try {
            PurchaseLedgerBook::find($id)->update($data);
            DB::commit();
            toast('Paymet Successfully Updated','success');
            return redirect()->back();

        } catch (\Exception $ex) {
            DB::rollBack();
            toast($ex->getMessage().'Paymet Update Faild','error');
            return redirect()->back();
        }
    }
}
