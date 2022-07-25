<?php

namespace App\Http\Controllers\Backend;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Stock;
use App\Models\Product;
use App\Models\InvoiceDue;
use Illuminate\Http\Request;
use App\Models\ProductionCal;
use App\Models\PurchaseInvoice;
use App\Models\PurchaseLedgerBook;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class SendToProductionController extends Controller
{
    public function showInvoiceTracking()
    {
        if ($error = $this->authorize('repack-unit-production-manage')) {
            return $error;
        }
        $showInvoices = PurchaseInvoice::with(['product','packSize'])->orderBy('id','DESC')->where('type', 9)->where('status', 1)->whereInv_cancel(0)->latest()->get();
        if(count($showInvoices)<1){
            alert()->info('Alert','There are no Data.');
            return redirect()->back();
        }
        $customerInfo = PurchaseInvoice::whereInv_cancel(0)->first();
        return view('admin.repack_unit.send_to_production.tracking', compact('showInvoices','customerInfo'));
    }

    // Bulk Tracking Start
    public function trackingUpdateOnGoing(Request $request, $id)
    {
        if ($error = $this->authorize('repack-unit-production-ongoing')) {
            return $error;
        }
        $data['tracking'] = $request->tracking;
        PurchaseInvoice::find($id)->update($data);
        return redirect()->back();
    }

    public function trackingUpdateComplete(Request $request, $id)
    {
        if ($error = $this->authorize('repack-unit-production-complete')) {
            return $error;
        }
        $data['tracking'] = $request->tracking;
        PurchaseInvoice::find($id)->update($data);
        return redirect()->back();
    }
    // Bulk Tracking End

    public function productId($id)
    {
        $showInvoices = PurchaseInvoice::whereInv_cancel(0)->find($id);
        $suppliers = User::where('role', 6)->get();
        return view('admin.repack_unit.send_to_production.index', compact('suppliers'));
    }

    // Production Cal
    public function productionCalShow($id)
    {
        if ($error = $this->authorize('repack-unit-production-show')) {
            return $error;
        }
        $poductionCals = ProductionCal::where('pur_inv_id', $id)->whereInv_cancel(0)->latest()->get();
        return view('admin.repack_unit.check.production_cal', compact('poductionCals'));
    }

    public function createId($inv_id)
    {
        if ($error = $this->authorize('repack-unit-production-send-to-store')) {
            return $error;
        }
        $products = Product::select(['id','generic','type'])->where('type',2)->get();
        $stores = User::where('role', 6)->get();
        $userId = User::select(['id','tmm_so_id','name'])->where('role', 1)->where('name','!=','Developer')->orwhere('role', 5)->orderby('business_name')->get();
        $getInvoice_no = PurchaseInvoice::select(['challan_no','type'])->where('type', 11)->whereInv_cancel(0)->get();
        $invoice_no = $getInvoice_no->groupBy('challan_no')->count() + 278;
        $invoice_id = PurchaseInvoice::where('id', $inv_id)->whereInv_cancel(0)->first();

        return view('admin.repack_unit.send_to_production.create', compact('invoice_no','userId','invoice_id','stores','products'));
    }

    public function store(Request $request)
    {
        if ($error = $this->authorize('repack-unit-production-send-to-store')) {
            return $error;
        }
       $this->validate($request,[
            'challan_no' => 'required',
            'size' => 'required',
            'quantity' => 'required',
        ]);

        DB::beginTransaction();

        $supplier_id = $request->get('supplier_id');
        $invoice_no = $request->get('invoice_no');
        $challan_no = $request->get('challan_no');
        $user_id = $request->get('user_id');
        $pur_product_id = $request->get('pur_product_id');
        $pur_size_id = $request->get('pur_size_id');
        $use_weight = $request->get('use_weight');
        $delivery_date = $request->get('delivery_date');
        $transaction_id = transaction_id('STP');

        // Purchase Invoice Start
        $invoiceArr = [];
        foreach($request->product_id as $key => $v){
            $data=[
                'tran_id' => $transaction_id,
                'user_id' => $user_id,
                'supplier_id' => $supplier_id,
                'product_id' => $request->product_id[$key],
                'type' => 11, // Send to Production
                'status' => 0, // For Check
                'challan_no' => $challan_no,
                'size' => $request->size[$key],
                'batch_no' => $request->batch_no[$key],
                'quantity' => $request->quantity[$key],
                'use_weight' => $request->use_weight, //$pur_size_id
                // 'net_weight' => $request->net_weight[$key], //$pur_product_id
                'invoice_date' => $delivery_date,
                // For test
                'pur_product_id' => $pur_product_id,
                'pur_size_id' => $pur_size_id,
            ];
            $invoice = PurchaseInvoice::create($data);
            $invoiceArr[] = $invoice->id;
        };

        $bulkStore=[
            'tran_id' => $transaction_id,
            'inv_id' => $invoice->id,
            'product_id' => $request->production_product_id,
            'product_pack_size_id' => $request->production_product_size,
            'type' => 12, //
            'stock_type' => 2, //Store
            'challan_no' => $challan_no,
            'quantity' => $request->use_weight,
            // 'bonus' => $request->bonus[$key],
            'use_weight' => $use_weight,
            // 'amt' => round($request->amt[$key]) - round($request->amt[$key])*$request->pro_dis[$key]/100,
            // 'dis' => $request->pro_dis[$key],
            // 'net_amt' => round($request->amt[$key]),
            'date' => $delivery_date,
        ];
        Stock::create($bulkStore);

        $pur_inv_id = $request->pur_inv_id;
        foreach ($request->product_id as $key => $v) {
            $productCal = [
                'tran_id' => $transaction_id,
                'pur_inv_id' => $pur_inv_id,
                'production_id' => $invoice->id,
                'product_id' => $request->product_id[$key],
                'challan_no' => $challan_no,
                'size' => $request->size[$key],
                'quantity' => $request->quantity[$key],
                'use_weight' => $request->use_weight,
                'date' => $delivery_date,
            ];
            ProductionCal::create($productCal);
        };

        $getUseWeight = PurchaseInvoice::where('id', $request->pur_inv_id)->first();
        $db_use_weight = $getUseWeight->use_weight;
        $db_net_weight = $getUseWeight->net_weight;
        $re_use_weight = $request->use_weight;
        $useWeight['use_weight'] = $request->use_weight + $getUseWeight->use_weight;
        PurchaseInvoice::where('id', $request->pur_inv_id)->update($useWeight);
        // Purchase Invoice End

        // Purchase Ledger Book Start
        $ledgerBook = [
            'tran_id' => $transaction_id,
            'user_id' => $user_id,
            'supplier_id' => $supplier_id,
            'prepared_id' => auth()->user()->id,
            'type' => 11, // Send to Production
            'challan_no' => $challan_no,
            'production_id' => $invoice->id,
            'invoice_date' => $delivery_date,
            'delivery_date' => $request->get('delivery_date'),
        ];
        // Sales Ledger Book End

        try {
            $ledgerBook = PurchaseLedgerBook::create($ledgerBook);
            $invoice == true;
            DB::commit();
            toast('Success','success');
            return redirect()->route('bulkTracking.showInvoice');
        } catch (\Exception $ex) {
            DB::rollBack();
            return $ex->getMessage();
            toast('Failed','error');
            return back();
        }
    }

    // public function 1productionDelete($production_id)
    // {
        // PurchaseInvoice::where('id',$production_id)->update(['inv_cancel' => 1]);
        // PurchaseLedgerBook::where('production_id',$production_id)->update(['inv_cancel' => 1]);
        // Stock::where('inv_id',$production_id)->update(['inv_cancel' => 1]);
        // ProductionCal::where('production_id',$production_id)->update(['inv_cancel' => 1]);
        // toast('success','Success');
        // return back();
    // }

    // Customer Invoice Show
    // public function show($id)
    // {
    //     $getInvoice = PurchaseInvoice::where('supplier_id', $id)->whereInv_cancel(0)->whereStatus(1)->latest()->get();
    //     $invoices = $getInvoice->groupBy('challan_no');
    //     if($supplierInfo == ''){
    //         alert()->info('Alert','There are no invoice. First create invoice');
    //         return redirect()->back();
    //     }
    //     return view('admin.repack_unit.send_to_production.customer_invoice', compact('invoices'));
    // }

    // Invoice Details
    public function showInvoice($supplier_id, $challan_no)
    {
        $showInvoices = PurchaseInvoice::where('supplier_id', $supplier_id)->where('challan_no', $challan_no)->whereInv_cancel(0)->get();
        $supplierInfo = PurchaseInvoice::where('supplier_id', $supplier_id)->whereInv_cancel(0)->first();
        $total_amt = PurchaseLedgerBook::where('challan_no', $challan_no)->whereInv_cancel(0)->first();
        return view('admin.repack_unit.send_to_production.show_invoice', compact('showInvoices','supplierInfo','total_amt'));
    }

    public function printInvoice($customer_id, $invoice_no)
    {
        $showInvoices = PurchaseInvoice::where('customer_id', $customer_id)->where('invoice_no', $invoice_no)->whereInv_cancel(0)->get();
        $customerInfo = PurchaseInvoice::where('customer_id', $customer_id)->whereInv_cancel(0)->first();
        $invoiceDue = InvoiceDue::where('invoice_no',$invoice_no)->get();
        $invoiceDueFirst = InvoiceDue::where('invoice_no',$invoice_no)->first();
        $ledger = PurchaseLedgerBook::where('invoice_no', $invoice_no)->whereInv_cancel(0)->first();
        return view('admin.bulk.send_to_repacking.print', compact('showInvoices','customerInfo','invoiceDue','ledger','invoiceDueFirst'));
    }

    public function selectDate()
    {
        if ($error = $this->authorize('repack-unit-production-report-manage')) {
            return $error;
        }
        return view('admin.repack_unit.production_report.select_date');
    }

    public function report(Request $request)
    {
        if ($error = $this->authorize('repack-unit-production-report-manage')) {
            return $error;
        }
        $form_date = $request->get('form_date');
        $to_date = $request->get('to_date');
        $productions = PurchaseInvoice::whereBetween('invoice_date', [$form_date,$to_date])->where('type', 11)->whereInv_cancel(0)->latest()->get();
        return view('admin.repack_unit.production_report.report', compact('productions','form_date','to_date'));
    }
}
