<div class="report_header text-center">
    <img src="{{ asset(setting('app_logo')) }}" width="70px" style="display: inline-block;margin:-141px 0 0 0px">
    <div class="report_header_text" style="display: inline-block; width: 485px; border-bottom: 1px solid black;">
        <h2><strong>Customer Name: </strong>{{$customer_Info->business_name}}</h2>
        <h2><strong>Proprietor: </strong>{{$customer_Info->name}}</h2>
        <p>
            <span><strong>Customer Phone: </strong>{{$customer_Info->phone}}</span><br>
            <span><strong>Address: </strong>{{$customer_Info->address}}</span><br>
            @isset($customer_Info->customerInfo->credit_limit)
            <span><strong>Credit Limit: </strong>{{number_format($customer_Info->customerInfo->credit_limit,2)}}</span><br>
            @endisset
        </p>
    </div>
</div>
