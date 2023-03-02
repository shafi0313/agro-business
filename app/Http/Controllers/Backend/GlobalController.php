<?php

namespace App\Http\Controllers\Backend;

use App\Models\Stock;
use App\Models\IsReturn;
use App\Models\UserBankAc;
use App\Models\SalesInvoice;
use Illuminate\Http\Request;
use App\Models\ProductPackSize;
use App\Models\SalesLedgerBook;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class GlobalController extends Controller
{
    // For Bulk
    public function PurchaseProductSearch(Request $request)
    {
        $query = $request->get('term', '');
        $products = DB::table('products');
        if ($request->type=='product') {
            $products->where('generic', 'LIKE', '%'.$query.'%');
        }

        $products=$products->where('type', 2)->get();
        $data=array();
        foreach ($products as $product) {
            $data[]=array('id'=>$product->id, 'name'=>$product->generic);
        }
        if (count($data)) {
            return $data;
        } else {
            return ['id'=>'', 'name'=>''];
        }
    }

    public function bulkPackSize(Request $request)
    {
        $productSize = ProductPackSize::where('product_id', $request->cat_id)->where('type', 2)->get();
        $size = '';
        $size .= '<option value="0">Select</option>';
        foreach ($productSize as $sub) {
            $size .= '<option value="'.$sub->id.'">'.$sub->size.'</option>';
        }
        return json_encode(['productSize' => $productSize, 'size'=>$size]);
    }

    public function bulkSize(Request $request)
    {
        $p_id = $request->cat_id;
        $productPrice = ProductPackSize::where('id', $p_id)->first();
        $getTradeWeight =  $productPrice->size;
        $tradeWeight = intval(preg_replace("/[^0-9]/", '', $getTradeWeight));
        return json_encode(['productPrice' => $productPrice, 'tradeWeight'=>$tradeWeight]);
    }

    public function bulkPrice(Request $request)
    {
        $size_id = $request->size_id;
        $productPrice = ProductPackSize::where('id', $size_id)->first();
        $purchase =  $productPrice->purchase;
        return json_encode(['purchase' => $purchase]);
    }

    // For Sales
    public function productSearch(Request $request)
    {
        $query = $request->get('term', '');
        $products=DB::table('products');
        if ($request->type=='product') {
            $products->where('name', 'LIKE', '%'.$query.'%');
        }
        $products=$products->get();
        $data=array();
        foreach ($products as $product) {
            $data[]=array('id'=>$product->id, 'name'=>$product->name, 'generic'=>$product->generic);
        }
        if (count($data)) {
            return $data;
        } else {
            return ['id'=>'', 'name'=>''];
        }
    }

    public function productSize(Request $request)
    {
        $p_id = $request->cat_id;
        $productSize = ProductPackSize::where('product_id', $p_id)->where('type', 1)->get();
        $size = '';
        $size .= '<option selected value disable>Select</option>';
        foreach ($productSize as $sub) {
            $size .= '<option value="'.$sub->id.'">'.$sub->size.'</option>';
        }
        return json_encode(['size'=>$size]);
    }

    public function productSizeId(Request $request)
    {
        $p_id = $request->size_text;
        $productSize = ProductPackSize::where('id', $p_id)->first();
        $size_text = $productSize->size;
        return json_encode(['size_text'=>$size_text]);
    }

    public function dueAmt(Request $request)
    {
        $p_id = $request->inv;
        $productPrice = SalesLedgerBook::where('invoice_no', $p_id)->first();
        $sales_amt =  $productPrice->sales_amt;
        $invoice_date =  $productPrice->invoice_date;
        return json_encode(['productPrice' => $productPrice, 'sales_amt'=>$sales_amt , 'invoice_date'=>$invoice_date]);
    }

    public function productPriceCash(Request $request)
    {
        $size_id = $request->size_id;
        $productPrice = ProductPackSize::where('id', $size_id)->first();
        $cash_price =  $productPrice->cash;
        return json_encode(['cash_price' => $cash_price]);
    }

    // Stock Check
    public function productStockCheck(Request $request)
    {
        $product_id = $request->product_id;
        $size_id = $request->size_id;
        $inStock = Stock::where('stock_close', 0)->where('inv_cancel', 0)->where('product_id', $product_id)->where('product_pack_size_id', $size_id)->whereIn('type', [0,11,20,21])->sum('quantity');
        $outStock = Stock::where('stock_close', 0)->where('inv_cancel', 0)->where('product_id', $product_id)->where('product_pack_size_id', $size_id)->whereIn('type', [1,3,5])->sum('quantity');
        $quantity = $inStock -  $outStock;

        return json_encode(['quantity'=>$quantity]);
    }

    public function productSizeCredit(Request $request)
    {
        $p_id = $request->cat_id;
        $productSize = ProductPackSize::where('product_id', $p_id)->get();
        $subCat = '';
        $subCat .= '<option value="0">Select</option>';
        foreach ($productSize as $sub) {
            $subCat .= '<option value="'.$sub->id.'">'.$sub->size.'</option>';
        }
        return json_encode(['productSize' => $productSize,'subCat'=>$subCat]);
    }

    public function bankAc(Request $request)
    {
        $bank_list_id = $request->bank_list_id;
        $bankAcNos = UserBankAc::where('bank_list_id', $bank_list_id)->get();
        $acNo = '';
        $acNo .= '<option value="0">Select</option>';
        foreach ($bankAcNos as $bankAcNo) {
            $acNo .= '<option value="'.$bankAcNo->id.'">'.$bankAcNo->ac_no.'</option>';
        }
        return json_encode(['acNo'=>$acNo]);
    }

    // For sales return
    public function invoiceSearch(Request $request)
    {
        $query = $request->get('term', '');
        $customer_id = $request->customer_id;
        // $isReturn = IsReturn::all()->pluck('sales_invoice_id');
        // $invoices = SalesInvoice::whereNotIn('id', $isReturn)
        $invoices = SalesInvoice::whereInv_cancel(0)
                    ->whereR_type(0)
                    ->whereIn('type', [1,3])
                    ->where('customer_id', $customer_id);
        if ($request->type == 'invoice_no') {
            $invoices->where('invoice_no', 'LIKE', '%'.$query.'%');
        }
        $invoices = $invoices->get();
        $data=array();
        foreach ($invoices as $invoice) {
            $data[]=array(
                'inv_id' => $invoice->id,
                'invoice_no' => $invoice->invoice_no.' ->'.$invoice->product->name,
                'product_id'=> $invoice->product->id,
                'product_name'=> $invoice->product->name,
                'size'=> $invoice->packSize->size,
                'size_id' => $invoice->packSize->id,
                'quantity' => $invoice->quantity,
                'bonus' => $invoice->bonus,
                'rate_per_qty' => $invoice->rate_per_qty,
                'pro_dis' => $invoice->pro_dis,
                'amt' => $invoice->amt,
            );
        }
        if (count($data)) {
            return $data;
        } else {
            return ['invoice_no'=>'', 'product_name'=>''];
        }
    }
}
