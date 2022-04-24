@include('admin.print_layout.invoice_header')
<style>
    .table .table tr td {
        border: 0px solid white !important;
    }
</style>
<div class="inv_s">Invoice Summery</div>
<table class="table table_bordered table-sm invoice_table">
    <thead>
        <tr>
            <th style="vertical-align: middle;">SL</th>
            <th>Invoice No</th>
            <th>Invoice Date</th>
            <th>Name of Product</th>
            <th>Size</th>
            <th>Pice/Bag</th>
            <th>Bonus</th>
            <th>Unit Price</th>
            <th>Dis</th>
            <th>Total Tk</th>
        </tr>
    </thead>
    @php $x=1; @endphp
    @foreach($showInvoices as $showInvoice)
    <tr>
        @php $snvoice = $showInvoice->first() @endphp
        <td class="text-center">{{ $x++ }}</td>

        @isset($snvoice->isReturnInvC->isReturnToInv->invoice_no)
        <td class="text-center">{{ $snvoice->isReturnInvC->isReturnToInv->invoice_no  }}</td>
        <td class="text-center">{{ BdDate($snvoice->isReturnInvC->isReturnToInv->invoice_date)  }}</td>
        @else
        <td></td>
        <td></td>
        @endisset
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
                    <td class="text-center" style="width: 140px">{{ number_format($item->rate_per_qty,2) }}</td>
                </tr>
                @endforeach
            </table>
        </td>
        <td class="p_0">
            <table class="table p_0">
                @foreach ($showInvoice as $item)
                <tr>
                    <td class="text-right" style="width: 140px">{{ number_format($item->pro_dis,2) }}</td>
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
        <input type="hidden" id="total_amt" value="{{abs($getShowInvoices->sum('amt'))}}">
        <td class="text-right" colspan="9" style="border: none !important">Total Amount: </td>
        <td class="text-right" style="border: none !important">{{ number_format($getShowInvoices->sum('amt'),2) }}</td>
    </tr>
    <tr class="total_amt">
        <td colspan="9" class="text-right" style="border: none !important">Discount(-):</td>
        <td class="text-right" style="border: none !important"><span
                class="net_border">{{ number_format(round($ledger->sales_amt * $ledger->discount/100),2) }}</span> </td>
    </tr>
    <tr class="net_amt " style="border-top: 1px ">
        <input id="net_amt" value="{{ abs($ledger->net_amt) }}" type="hidden">
        <td style="border: none !important" class="words_net" colspan="7">[ In word: <span id="words_net"></span>]</td>
        <td style="border: none !important" colspan="2" class="text-right">Net Payable: </td>
        <td style="border: none !important" class="text-right net_border"><span
                class="net_border2">{{ number_format(round($ledger->net_amt),2) }}</span> </td>
    </tr>
</table>
<br><br><br>

@if (isset($invoiceDueFirst->inv_date) )
<table class="table table-bordered table-sm due_table" style="width:550px !important">
    <tr class="thc">
        <td>Date</td>
        <td>Invoice No</td>
        <td>Payment</td>
        <td>Due</td>
    </tr>
    <div style="font-size: 18px; font-weight: bold; padding-left: 20px">Due Invoice: </div>
    @foreach ($invoiceDue as $item)
    <tr>
        <td class="text-center">{{ \Carbon\Carbon::parse($item->inv_date)->format('d/m/Y') }}</td>
        <td class="text-center">{{$item->invoice_no}}</td>
        <td class="text-right">{{$item->inv_payment}}</td>
        <td class="text-right">{{$item->inv_total}}</td>
    </tr>
    @endforeach
    <tr>
        <td colspan="3" class="text-right">Total Due: </td>
        <td class="text-right">{{ number_format($invoiceDue->sum('inv_total'),2) }}</td>
    </tr>
</table>
@endif
{{-- /Invoice Due Table --}}

<footer>
    <div class="">
        <table class="table footer_info">
            <tr>
                <td>{{$ledger->preparedBy->tmm_so_id}}</td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>-----------------</td>
                <td style="padding-left: 205px">------------------------------------</td>
                <td class="text-right">------------------</td>
            </tr>
            <tr>
                <td style="padding-left: 12px">Prepared By</td>
                <td style="padding-left: 220px">Customer Signature and Date</td>
                <td style="padding-left: 224px">Approved By</td>
            </tr>
        </table>
    </div>
    <div class="conpany_info" style="font-size: 15px;">
        Head office: High Road, Alamdanga, Chuadanga. <i class="fas fa-tty"></i> 07622-56385, <i
            class="fas fa-mobile-alt"></i>+8801318-302500,
        Dhaka Office: House # 14, Road # 3, <br> Block # E, Extended Rupnagar (R/A) Sector # 12, Mirpur, Dhaka-1216.
        <i class="far fa-envelope"></i> r.tuhin@icloud.com, <i class="fas fa-globe-asia"></i> www.mondolag.com
    </div>
</footer>
</div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"
    integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg=="
    crossorigin="anonymous"></script>
<script>
    var a = ['', 'one ', 'two ', 'three ', 'four ', 'five ', 'six ', 'seven ', 'eight ', 'nine ', 'ten ', 'eleven ',
        'twelve ', 'thirteen ', 'fourteen ', 'fifteen ', 'sixteen ', 'seventeen ', 'eighteen ', 'nineteen '
    ];
    var b = ['', '', 'twenty', 'thirty', 'forty', 'fifty', 'sixty', 'seventy', 'eighty', 'ninety'];

    function inWords(num) {
        if ((num = num.toString()).length > 9) return 'overflow';
        n = ('000000000' + num).substr(-9).match(/^(\d{2})(\d{2})(\d{2})(\d{1})(\d{2})$/);
        if (!n) return;
        var str = '';
        str += (n[1] != 0) ? (a[Number(n[1])] || b[n[1][0]] + ' ' + a[n[1][1]]) + 'crore ' : '';
        str += (n[2] != 0) ? (a[Number(n[2])] || b[n[2][0]] + ' ' + a[n[2][1]]) + 'lakh ' : '';
        str += (n[3] != 0) ? (a[Number(n[3])] || b[n[3][0]] + ' ' + a[n[3][1]]) + 'thousand ' : '';
        str += (n[4] != 0) ? (a[Number(n[4])] || b[n[4][0]] + ' ' + a[n[4][1]]) + 'hundred ' : '';
        str += (n[5] != 0) ? ((str != '') ? 'and ' : '') + (a[Number(n[5])] || b[n[5][0]] + ' ' + a[n[5][1]]) +
            'taka only ' : '';
        return str;
    }
    var net_amt = Math.round(document.getElementById('net_amt').value)
    document.getElementById('words_net').innerHTML = inWords(net_amt);
</script>

<script>
    $(document).ready(function () {
        window.print();
    });
</script>
</body>

</html>
