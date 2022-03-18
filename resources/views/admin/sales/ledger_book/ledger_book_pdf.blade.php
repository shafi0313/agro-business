<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title></title>
    <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0/css/bootstrap.css"
        integrity="sha512-wtjMa8AnvUyCbLxFg1jLR88gSACq81IiYgtIVdeNo3k+M8rdo4JdfScn7WxbZDsxZxFyDOEpMqOvYCzpSM6hnw=="
        crossorigin="anonymous" />

</head>
<body style="font-size: 12px !important">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h3><strong>Customer Name: </strong>{{$supplierInfo->supplier->name}}</h3>
                    <p>
                        <span><strong>Customer Phone: </strong>{{$supplierInfo->supplier->phone}}</span><br>
                        <span><strong>Customer Address: </strong>{{$supplierInfo->supplier->address}}</span><br>
                    </p>
                </div>
                <div class="col-md-6 text-right my-auto">
                    <h3 style="font-weight:bold;">Form: {{ \Carbon\Carbon::parse($form_date)->format('d/m/Y') }}
                    To: {{ \Carbon\Carbon::parse($to_date)->format('d/m/Y') }}</h3>
                </div>
            </div>
            <div class="table-responsive">
                {{-- <style>table thead tr th,table tbody tr td{padding: 0 !important; margin: 0 !important}</style> --}}
                <table class="table table-bordered table-striped table-hover table-sm">
                    <thead class="bg-secondary thw">
                        <tr>
                            <th style="width:35px">SL</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>In. No.</th>
                            <th>Sales Amt</th>
                            <th>Received Name</th>
                            <th>Received By</th>
                            <th>Received</th>
                        </tr>
                    </thead>

                    <tbody>
                        @php $x=1; @endphp
                        @foreach($invoices as $invoice)
                        <tr class="{{ ($invoice->invoice_status == "1")? 'text-danger' : '' }}">
                            <td class="text-center">{{ $x++ }}</td>
                            <td>{{ \Carbon\Carbon::parse($invoice->invoice_date)->format('d/m/Y') }}</td>
                            <td>{{ ($invoice->invoice_status == "0")? 'Sale' : (($invoice->invoice_status == "1") ? 'Return':'Payment') }}</td>
                            <td class="text-center">{{ $invoice->invoice_no }}</td>
                            <td class="text-right">{{ number_format(abs($invoice->total_amt),2) }}</td>
                            <td class="text-center">{{ $invoice->note }}</td>
                            <td class="text-center">{{ $invoice->amt_by }}</td>
                            <td class="text-right">{{ number_format($invoice->payment,2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <style>
                        tfoot tr td {
                            text-align: right;
                            font-weight: bold;
                            /* font-size: 12px !important */
                        }
                    </style>
                    <tfoot>
                        <tr>
                            <td colspan="4">Total Sales Amount: </td>
                            <td>{{ number_format($purchaseInvoices->sum('total_amt'),2) }}</td>
                            <td></td>
                            <td></td>
                            <td>{{ number_format($purchaseInvoices->sum('payment'),2) }}</td>
                        </tr>
                        <tr class="text-danger">
                            <td colspan="4">Total Return Sales Amount: </td>
                            <td>{{ number_format(abs($returnPurchaseInvoices->sum('total_amt')),2) }}</td>
                            <td></td>
                            <td></td>
                            <td>{{ number_format($payment->sum('payment'),2) }}</td>
                        </tr>
                        <tr>
                            <td colspan="4">Total Amount: </td>
                            <td>{{ number_format($purchaseInvoices->sum('total_amt') - abs($returnPurchaseInvoices->sum('total_amt')),2) }}</td>
                            <td></td>
                            <td></td>
                            <td>{{ number_format($purchaseInvoices->sum('payment'),2) }}</td>
                        </tr>
                    </tfoot>
                </table>
                <div>
                    <h3 class="text-right"><strong>Total Due: {{ number_format($purchaseInvoices->sum('total_amt') - abs($returnPurchaseInvoices->sum('total_amt')) - $payment->sum('payment'),2) }}</strong></h3>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
