@include('admin.sample_print_layout.invoice_header')
<style>
    .table .table tr td{
        border: 0px solid white !important;
    }
</style>
            <div class="inv_s">Invoice Summery</div>
            <table class="table table_bordered table-sm invoice_table">
                <thead>
                    <tr>
                        <th style="vertical-align: middle;">SL</th>
                        <th>Name of Product</th>
                        <th>Size</th>
                        <th>Pice/Bag</th>
                        <th>Bonus</th>
                        <th>Unit Price</th>
                        <th>Total Tk</th>
                    </tr>
                </thead>
                @php $x=1; @endphp
                @foreach($showInvoices as $showInvoice)
                <tr>
                    @php $snvoice = $showInvoice->first() @endphp
                    <td class="text-center">{{ $x++ }}</td>
                    <td>{{ $snvoice->product->name }}</td>
                    <td class="p_0">
                        <table class="table" style="border: 0px !important; padding:0px !important; margin: 0px !important; ">
                            @foreach ($showInvoice as $item)
                                <tr>
                                    <td class="text-center">{{ $item->packSize->size }}</td>
                                </tr>
                                @endforeach
                        </table>
                    </td>
                    <td class="p_0">
                        <table class="table p_0">
                            @foreach ($showInvoice as $item)
                                <tr>
                                    <td class="text-center">{{ $item->quantity }}</td>
                                </tr>
                                @endforeach
                        </table>
                    </td>
                    <td class="p_0">
                        <table class="table p_0">
                            @foreach ($showInvoice as $item)
                                <tr>
                                    <td class="text-center">{{ $item->bonus }}</td>
                                </tr>
                                @endforeach
                        </table>
                    </td>
                    <td class="p_0">
                        <table class="table p_0">
                            @foreach ($showInvoice as $item)
                                <tr>
                                    <td class="text-right" style="width: 140px">{{ number_format($item->rate_per_qty,2) }}</td>
                                </tr>
                                @endforeach
                        </table>
                    </td>
                    <td class="p_0">
                        <table class="table p_0">
                            @foreach ($showInvoice as $item)
                                <tr>
                                    <td class="text-right" style="width: 140px">{{ number_format($item->amt,2) }}</td>
                                </tr>
                                @endforeach
                        </table>
                    </td>

                </tr>
                @endforeach

                <tr class="total_amt">
                    <input type="hidden" id="total_amt" value="{{$getShowInvoices->sum('amt')}}" >
                    <td class="text-right" colspan="6" style="border: none !important">Total Amount: </td>
                    <td class="text-right" style="border: none !important">{{ number_format($getShowInvoices->sum('amt'),2) }}</td>
                </tr>
                <tr class="total_amt">
                    <td colspan="6" class="text-right" style="border: none !important">Discount(-):</td>
                    <td class="text-right" style="border: none !important"><span class="net_border">{{ number_format(round($ledger->sales_amt * $ledger->discount/100),2) }}</span> </td>
                </tr>
                <tr class="net_amt " style="border-top: 1px ">
                    <input id="net_amt" value="{{$ledger->net_amt}}" type="hidden">
                    <td style="border: none !important" class="words_net" colspan="4">[ In word: <span id="words_net"></span>]</td>
                    <td style="border: none !important" colspan="2" class="text-right">Net Payable: </td>
                    <td style="border: none !important" class="text-right net_border"><span class="net_border2">{{ number_format(round($ledger->net_amt),2) }}</span> </td>
                </tr>
            </table>

            <br>
            <div class="delivery_date">Delivery Date: {{ \Carbon\Carbon::parse($ledger->delivery_date)->format('d/m/Y') }}</div>
            <br><br>

            @isset($ledger->sampleNote->note)
            <p style="color: blue"><b>Particulars:</b> {{ $ledger->sampleNote->note }}</p>
            @endisset


@include('admin.sample_print_layout.invoice_footer')
