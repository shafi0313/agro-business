<h2><strong>Supplier Name: </strong>{{$supplierInfo->supplier->name}}</h2>
<p>
    <span><strong>No: </strong>{{$supplierInfo->challan_no}}</span><br>
    <span><strong>Date: </strong>{{ \Carbon\Carbon::parse($supplierInfo->invoice_date)->format('d/m/Y') }}</span><br>
    {{-- <span><strong>Customer Phone: </strong>{{$supplierInfo->supplier->phone}}</span><br>
    <span><strong>Customer Address: </strong>{{$supplierInfo->supplier->address}}</span><br> --}}
</p>
