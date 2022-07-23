<?php

namespace App\Http\Controllers\Backend;

use Carbon\Carbon;
use App\Models\User;
use App\Models\ProductStock;
use Illuminate\Http\Request;
use App\Models\EquipmentPurchase;
use App\Models\PurchaseLedgerBook;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class LabelPurchaseController extends Controller
{
    public function index()
    {
        $suppliers = User::select(['id','name','tmm_so_id','business_name','phone','address','role'])->where('role', 3)->orderby('business_name', 'ASC')->get();
        return view('admin.label.purchase.index', compact('suppliers'));
    }

    public function createId($id)
    {
        if ($error = $this->sendPermissionError('create')) {
            return $error;
        }
        $userId = User::select(['id','tmm_so_id','role','name'])->where('role', 1)->where('name', '!=', 'Developer')->orwhere('role', 5)->get();
        $supplier = User::select(['id','name','email','phone','address'])->find($id);
        return view('admin.label.purchase.create', compact('supplier', 'userId', ));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'challan_no' => 'required',
            'size' => 'required',
            'quantity' => 'required',
            'rate_per_qty' => 'required',
            'amt' => 'required',
            'invoice_date' => 'required',
        ]);

        $supplier_id = $request->get('supplier_id');
        $invoice_no = $request->get('invoice_no');
        $challan_no = $request->get('challan_no');
        $user_id = $request->get('user_id');
        $invoice_date = $request->invoice_date;
        $transaction_id = transaction_id('BPU');

        DB::beginTransaction();

        $invoiceArr = [];
        // Purchase Invoice Start
        foreach ($request->product_id as $key => $v) {
            $data=[
                'tran_id' => $transaction_id,
                'user_id' => $user_id,
                'supplier_id' => $supplier_id,
                'product_id' => $request->product_id[$key],
                'type' => 7, // Purchase Bulk
                'status' => 1,
                'invoice_no' => $invoice_no,
                'challan_no' => $challan_no,
                'size' => $request->size[$key], // weight
                'quantity' => $request->quantity[$key],
                'rate_per_qty' => $request->rate_per_qty[$key],
                'net_weight' => $request->net_weight[$key],
                'amt' => round($request->amt[$key]),
                'invoice_date' => $invoice_date,
            ];
            $invoice = PurchaseInvoice::create($data);
            $invoiceArr[] = $invoice->id;
        }

        // Purchase Invoice End

        // Bulk Store Start
        foreach ($request->product_id as $key => $v) {
            $data=[
                'tran_id' => $transaction_id,
                'inv_id' => $invoiceArr[$key],
                'product_id' => $request->product_id[$key],
                'product_pack_size_id' => $request->size[$key],
                'type' => 7, // Bulk Purchase
                'stock_type' => 2, //Bulk
                'challan_no' => $challan_no,
                'quantity' => $request->quantity[$key],
                // 'bonus' => $request->bonus[$key],
                'net_weight' => $request->net_weight[$key],
                // 'amt' => round($request->amt[$key]) - round($request->amt[$key])*$request->pro_dis[$key]/100,
                // 'dis' => $request->pro_dis[$key],
                'net_amt' => round($request->amt[$key]),
                'date' => $request->invoice_date,
            ];
            Stock::create($data);
        };

        // Purchase Ledger Book Start
        $ledgerBook = [
            'tran_id' => $transaction_id,
            'user_id' => $user_id,
            'supplier_id' => $supplier_id,
            'prepared_id' => auth()->user()->id,
            'type' => 7,
            'invoice_no' => $invoice_no,
            'challan_no' => $challan_no,
            'purchase_amt' => $request->get('total_amt'),
            'discount' => $request->get('discount'),
            'net_amt' => round($request->get('net_amt')),
            'payment' => round($request->get('payment')),
            'payment_date' =>  $request->get('payment_date'),
            'user_type' =>  $request->get('user_type'),
            'invoice_date' =>$invoice_date,
            'delivery_date' => $request->get('delivery_date'),
        ];
        // Purchase Ledger Book End

        try {
            $ledgerBook = PurchaseLedgerBook::create($ledgerBook);
            $invoice == true;
            // $stockUpdate== true;
            DB::commit();
            toast('Purchase Bulk Successfully Inserted', 'success');
            return redirect()->route('purchase-bulk.index');
        } catch (\Exception $ex) {
            DB::rollBack();
            toast($ex->getMessage().'Purchase Bulk Inserted Failed', 'error');
            return back();
        }
    }

    // Customer Invoice Show
    public function show($id)
    {
        $supplierInfo = EquipmentPurchase::where('supplier_id', $id)->where('type', 13)->first();
        $getChallan = EquipmentPurchase::where('supplier_id', $id)->where('type', 13)->latest()->get();
        $supplierChallans = $getChallan->groupBy('challan_no');
        if ($supplierInfo == '') {
            alert()->info('Alert', 'There are no invoice. First create invoice');
            return redirect()->back();
        }
        return view('admin.label.purchase.customer_invoice', compact('supplierChallans', 'supplierInfo'));
    }

    // Invoice Details
    public function showInvoice($supplier_id, $challan_no)
    {
        $showInvoices = EquipmentPurchase::where('supplier_id', $supplier_id)->where('challan_no', $challan_no)->where('type', 13)->get(); // 7 = Purchase Bulk
        $supplierInfo = EquipmentPurchase::where('supplier_id', $supplier_id)->where('type', 13)->first();
        return view('admin.label.purchase.show_invoice', compact('showInvoices', 'supplierInfo'));
    }

    // All
    public function allInvoice()
    {
        $getChallan = EquipmentPurchase::where('type', 13)->latest()->get();
        $supplierChallans = $getChallan->groupBy('challan_no');
        return view('admin.label.purchase.all_invoice', compact('supplierChallans'));
    }

    public function allInvoiceShow($challan_no)
    {
        $showInvoices = EquipmentPurchase::where('challan_no', $challan_no)->where('type', 13)->get(); // 7 = Label Purchase
        $supplierInfo = EquipmentPurchase::where('type', 13)->first();
        return view('admin.label.purchase.all_invoice_show', compact('showInvoices', 'supplierInfo'));
    }

    public function selectDate()
    {
        return view('admin.label.purchase.select_date');
    }

    public function allInvoiceByDate(Request $request)
    {
        $form_date = $request->get('form_date');
        $to_date = $request->get('to_date');

        $getChallan = EquipmentPurchase::whereBetween('invoice_date', [$form_date,$to_date])->where('type', 7)->latest()->get();
        $supplierChallans = $getChallan->groupBy('challan_no');
        return view('admin.label.purchase.all_invoice_by_date', compact('supplierChallans'));
    }

    public function allInvoiceShowByDate($challan_no)
    {
        $showInvoices = EquipmentPurchase::where('challan_no', $challan_no)->where('type', 7)->get(); // 7 = Purchase label
        $supplierInfo = EquipmentPurchase::where('type', 7)->first();
        return view('admin.label.purchase.all_invoice_show_by_date', compact('showInvoices', 'supplierInfo'));
    }

    public function destroyInvoice($invoice_no)
    {
        if ($error = $this->sendPermissionError('delete')) {
            return $error;
        }
        EquipmentPurchase::where('invoice_no', $invoice_no)->delete();
        PurchaseLedgerBook::where('invoice_no', $invoice_no)->delete();
        if (EquipmentPurchase::count() < 1) {
            toast('Invoice Successfully Deleted', 'success');
            return redirect()->route('purchase-invoice.index');
        } else {
            toast('Invoice Successfully Deleted', 'success');
            return redirect()->back();
        }
    }
}
