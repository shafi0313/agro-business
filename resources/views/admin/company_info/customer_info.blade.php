<h2><strong>Name: </strong>{{$customerInfo->customer->business_name}}</h2>
<h2><strong>Proprietor: </strong>{{$customerInfo->customer->name}}</h2>
<p>
    <span><strong>Challan No: </strong>{{$customerInfo->challan_no}}</span><br>
    <span><strong>Invoice No: </strong>{{$customerInfo->invoice_no}}</span><br>
    <span><strong>Date: </strong>{{ \Carbon\Carbon::parse($customerInfo->invoice_date)->format('d/m/Y') }}</span><br>
    {{-- <span><strong>Phone: </strong>{{$customerInfo->customer->phone}}</span><br>
    <span><strong>Address: </strong>{{$customerInfo->customer->address}}</span><br> --}}
</p>
