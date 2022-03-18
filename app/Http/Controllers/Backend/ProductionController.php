<?php

namespace App\Http\Controllers\Backend;

use App\Models\Stock;
use App\Models\SalesInvoice;
use Illuminate\Http\Request;
use App\Models\PurchaseInvoice;
use App\Models\SalesLedgerBook;
use App\Models\PurchaseLedgerBook;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class ProductionController extends Controller
{
    public function showAccpet()
    {
        if ($error = $this->sendPermissionError('create')) {
            return $error;
        }
        $customerInfo = PurchaseInvoice::first();
        $getInvoice = PurchaseInvoice::where('type', 11)->latest()->get();
        $customerInvoices = $getInvoice->groupBy('challan_no');
        if ($customerInfo == '') {
            alert()->info('Alert', 'There are no invoice. First create invoice');
            return redirect()->back();
        }
        return view('admin.production.check.customer_invoice_accpet', compact('customerInvoices', 'customerInfo'));
    }

    public function showInvoiceAccpet($challan_no)
    {
        if ($error = $this->sendPermissionError('create')) {
            return $error;
        }
        $showInvoices = PurchaseInvoice::where('challan_no', $challan_no)->where('type', 11)->get();
        $customerInfo = PurchaseInvoice::first();
        $total_amt = PurchaseLedgerBook::where('challan_no', $challan_no)->first();
        return view('admin.production.check.show_invoice_accpet', compact('showInvoices', 'customerInfo', 'total_amt'));
    }
    // For Check end

    public function store(Request $request)
    {
        // return $request;
        DB::beginTransaction();
        foreach ($request->id as $key => $v) {
            $data=[
                "status" => ($request->a == 'Accept')?'1':'2',
            ];
            PurchaseInvoice::where('id', $request->id[$key])->first()->update($data);
        }
        // Stock Update
        if ($request->a == 'Accept') {
            foreach ($request->product_id as $key => $v) {
                $data=[
                    'tran_id' => transaction_id('PDN'),
                    'inv_id' => $request->spSizeId[$key],
                    'product_id' => $request->product_id[$key],
                    'product_pack_size_id' => $request->size[$key],
                    'type' => 11,
                    'stock_type' => 1,
                    'challan_no' => $request->challan_no[$key],
                    'quantity' => $request->quantity[$key],
                    'use_weight' => $request->use_weight[$key],
                    // 'bonus' => $request->bonus[$key],
                    // 'amt' => round($request->amt[$key]) - round($request->amt[$key])*$request->pro_dis[$key]/100,
                    // 'dis' => $request->pro_dis[$key],
                    // 'net_amt' => round($request->amt[$key]),
                    'date' => $request->invoice_date[$key],
                ];
                Stock::create($data);
            };
        }
        try {
            // ($bulkUpdatee == true || $factoryUpdatee == true);
            DB::commit();
            toast('Done', 'success');
            return redirect()->route('productionCheck.showAccpet');
        } catch (\Exception $ex) {
            DB::rollBack();
            toast($ex->getMessage().'Failed', 'error');
            return back();
        }
    }

    // Soft Delete
    public function destroyInvoice($challan_no)
    {
        if ($error = $this->sendPermissionError('delete')) {
            return $error;
        }
        SalesInvoice::where('challan_no', $challan_no)->delete();
        SalesLedgerBook::where('challan_no', $challan_no)->delete();
        if (SalesInvoice::count() < 1) {
            toast('Sales Invoice Successfully Deleted', 'success');
            return redirect()->route('invoice.index');
        } else {
            toast('Sales Invoice Successfully Deleted', 'success');
            return redirect()->back();
        }
    }

    public function destroy(Request $request, $id)
    {
        if ($error = $this->sendPermissionError('delete')) {
            return $error;
        }
        SalesInvoice::find($id)->delete();
        $challan_no = $request->get('challan_no');
        $customer_id = $request->get('customer_id');
        $invoices = SalesInvoice::select('amt')->where('challan_no', $challan_no)->where('customer_id', $customer_id)->get()->sum('amt');

        $ledgerBooks = SalesLedgerBook::where('challan_no', $challan_no)->where('customer_id', $customer_id)->get();

        foreach ($ledgerBooks as $ledgerBook) {
            $courier_pay = $ledgerBook->courier_pay;
            $payment = $ledgerBook->payment;
        }

        $ledgerUpdate = [
            'total_amt' =>$invoices,
            'dues_amt' =>$invoices - $courier_pay - $payment,
        ];
        SalesLedgerBook::where('challan_no', $challan_no)->where('customer_id', $customer_id)->update($ledgerUpdate);
        return redirect()->back();
    }
}
