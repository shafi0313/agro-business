<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="{{ asset('backend/assets/css/print.css')}}">
    <link rel="preconnect" href="https://fonts.gstatic.com">

    <link href="https://fonts.googleapis.com/css2?family=Galada&display=swap" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" integrity="sha512-+4zCK9k+qNFUR5X+cKL9EIR+ZOhtIloNl9GIKS57V1MyNsYpYcUrUeQc9vNfzsWfV28IaLL3i96P9sdNyeRssA==" crossorigin="anonymous" />

    <title>Invoice</title>
  </head>

  <body>
    <div  class="page">
        <div class="print_page" id="print_page">
            <div class="bg_img"><img src="{{asset(setting('app_logo'))}}" alt=""></div>
            <div class="header" >
                <div class="heater_text">
                    <ul style="margin: 0; padding:0">
                        <li class="title">MONDOL TRADERS</li>
                        <li style="font-size: 18px; margin-left: 22px">Alamdanga, Chuadanga.</li>
                    </ul>
                </div>
                <div class="img">
                    <div class="print_date">{{date('d/m/Y h:i:sa')}}</div>
                    <img src="{{asset('images/icons/company_logo_invoice.png')}}" alt="">
                </div>
            </div>
            <div class="inv_info">
                <div class="customer_info">
                    <table>
                        <tr>
                            <td>Customer Id </td>
                            <td>&nbsp;:</td>
                            <td>{{$ledger->customer->tmm_so_id}}</td>
                        </tr>
                        <tr>
                            <td>Name</td>
                            <td>&nbsp;:</td>
                            <td>{{$ledger->customer->business_name}}</td>
                        </tr>
                        <tr>
                            <td>Pro.</td>
                            <td>&nbsp;:</td>
                            <td>{{$ledger->customer->name}}</td>
                        </tr>
                        @php $dis = $ledger->customer->address; @endphp
                        <tr>
                            <td>Address</td>
                            <td>&nbsp;:</td>
                            <td>{{ substr($dis, 0, strrpos($dis, " ")) }}</td>
                        </tr>
                        <tr>
                            <td class="text-right" colspan="2">:</td>
                            <td>{{ substr($dis, strrpos($dis, ' ')) }}</td>
                        </tr>
                        <tr>
                            <td>Contact</td>
                            <td>&nbsp;:</td>
                            <td>0{{ $ledger->customer->phone }}</td>
                        </tr>
                        <tr>
                            <td>Type</td>
                            <td>&nbsp;:</td>
                            <td>{{ $ledger->user_type }}</td>
                        </tr>
                    </table>
                </div>

                <div class="invoice_info">
                    <div class="invoice_text">INVOICE</div>
                    <table>
                        <tr>
                            <td class="text-right">Invoice Number</td>
                            <td>&nbsp;:</td>
                            <td>{{$ledger->invoice_no}}</td>
                        </tr>
                        <tr>
                            <td class="text-right">Challan Number</td>
                            <td>&nbsp;:</td>
                            <td>{{ $ledger->challan_no }}</td>
                        </tr>
                        <tr>
                            <td class="text-right">Invoice Date</td>
                            <td>&nbsp;:</td>
                            <td>{{ \Carbon\Carbon::parse($ledger->invoice_date)->format('d/m/Y') }}</td>
                        </tr>
                        {{-- <tr>
                            <td class="text-right text-danger">Payment Date</td>
                            <td>&nbsp;:</td>
                            <td class="text-danger">{{ \Carbon\Carbon::parse($ledger->payment_date)->format('d/m/Y') }}</td>
                        </tr> --}}
                        <tr>
                            <td class="text-right">Sales Method</td>
                            <td>&nbsp;:</td>
                            <td>Sample</td>
                        </tr>
                        <tr>
                            <td class="text-right">TMM/SO Id</td>
                            <td>&nbsp;:</td>
                            <td>{{$ledger->tmmSoId->tmm_so_id}}</td>
                        </tr>
                    </table>
                </div>
            </div>
