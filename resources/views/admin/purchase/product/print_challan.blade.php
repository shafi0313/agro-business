@include('admin.print_layout.challan_header')
<style>
    .table .table tr td {
        border: 0px solid white !important;
    }
</style>
<div class="inv_s">Challan Summery</div>
<table class="table table_bordered table-sm invoice_table">
    <thead>
        <tr>
            <th style="vertical-align: middle;">SL</th>
            <th>Name of Product</th>
            <th>Size</th>
            <th>Pice/Bag</th>
            <th>Bonus</th>
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
    </tr>
    @endforeach
</table>
<br><br><br>
<div class="delivery_date">Delivery Date: {{ \bdDate($ledger->delivery_date) }}</div>
<br><br>
@if($ledger->inv_cancel==1)
    <div class="note" style="color:red">Challan Cancel</div>
@elseif($ledger->inv_cancel==2)
    <div class="note" style="color:red">Rechallan</div>
<br>
@endif
@if ($ledger->inv_cancel==1)
    @isset($ledger->sampleNote->note)
        <div class="note">Note: {{ $ledger->sampleNote->note }}</div>
    @endisset
@endif
<br><br>
@include('admin.print_layout.challan_footer')
