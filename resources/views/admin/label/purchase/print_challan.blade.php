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

    <title>Challan</title>
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
                            <td>Supplier Id </td>
                            <td>&nbsp;:</td>
                            <td>{{$ledger->supplier->tmm_so_id}}</td>
                        </tr>
                        <tr>
                            <td>Name</td>
                            <td>&nbsp;:</td>
                            <td>{{$ledger->supplier->business_name}}</td>
                        </tr>
                        <tr>
                            <td>Pro.</td>
                            <td>&nbsp;:</td>
                            <td>{{$ledger->supplier->name}}</td>
                        </tr>
                        {{-- @php $dis = $ledger->supplier->address; @endphp --}}
                        <tr>
                            <td>Address</td>
                            <td>&nbsp;:</td>
                            {{-- <td>{{ substr($dis, 0, strrpos($dis, " ")) }}</td> --}}
                            <td>{{ $ledger->supplier->address }}</td>
                        </tr>
                        {{-- <tr>
                            <td class="text-right" colspan="2">:</td>
                            <td>{{ substr($dis, strrpos($dis, ' ')) }}</td>
                        </tr> --}}
                        <tr>
                            <td>Contact</td>
                            <td>&nbsp;:</td>
                            <td>0{{ $ledger->supplier->phone }}</td>
                        </tr>
                        <tr>
                            <td>Type</td>
                            <td>&nbsp;:</td>
                            <td>{{ $ledger->user_type }}</td>
                        </tr>
                    </table>
                </div>

                <div class="invoice_info">
                    <div class="invoice_text">CHALLAN</div>
                    <table>
                        <tr>
                            <td class="text-right">Challan Number</td>
                            <td>&nbsp;:</td>
                            <td>{{ $ledger->challan_no }}</td>
                        </tr>
                        <tr>
                            <td class="text-right">Invoice Number</td>
                            <td>&nbsp;:</td>
                            <td>{{$ledger->invoice_no}}</td>
                        </tr>
                        <tr>
                            <td class="text-right">Challan Date</td>
                            <td>&nbsp;:</td>
                            <td>{{ \Carbon\Carbon::parse($ledger->invoice_date)->format('d/m/Y') }}</td>
                        </tr>
                        <tr>
                            <td class="text-right" style="color: blue">Payment Date</td>
                            <td>&nbsp;:</td>
                            <td style="color: blue">{{ \Carbon\Carbon::parse($ledger->payment_date)->format('d/m/Y') }}</td>
                        </tr>
                        <tr>
                            <td class="text-right">Sales Method</td>
                            <td>&nbsp;:</td>
                            <td>Cash</td>
                        </tr>
                        <tr>
                            <td class="text-right">Officer Id</td>
                            <td>&nbsp;:</td>
                            <td>{{$ledger->tmmSoId->tmm_so_id}}</td>
                        </tr>
                    </table>
                </div>
            </div>

<style>
    .table .table tr td{
        border: 0px solid white !important;
    }
</style>
            <div class="inv_s">Challan Summery</div>
            <table class="table table_bordered table-sm invoice_table">
                <thead>
                    <tr>
                        <th style="vertical-align: middle;">SL</th>
                        <th>Name of Group</th>
                        <th>Size</th>
                        <th>Pice/Bag</th>
                        <th>Net Weight</th>
                    </tr>
                </thead>
                @php $x=1; @endphp
                @foreach($showInvoices as $showInvoice)
                <tr>
                    @php $snvoice = $showInvoice->first() @endphp
                    <td class="text-center">{{ $x++ }}</td>
                    <td>{{ $snvoice->product->generic }}</td>
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
                                    <td class="text-center">{{ $item->net_weight }}</td>
                                </tr>
                                @endforeach
                        </table>
                    </td>
                </tr>
                @endforeach
            </table>
            <br>
            <br>
            <br>
            {{-- <div class="delivery_date">Delivery Date: {{ \Carbon\Carbon::parse($ledger->delivery_date)->format('d/m/Y') }}</div> --}}
            <br><br>

            <footer>
                <div class="">
                    <table class="table footer_info">
                        <tr>
                            <td>{{$ledger->preparedBy->tmm_so_id}}</td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>-----------------</td>
                            <td style="padding-left: 200px">-----------------------</td>
                            <td class="text-right">--------------------------</td>
                        </tr>
                        <tr>
                            <td style="padding-left: 10px">Prepared By</td>
                            <td style="padding-left: 225px">Authorized By</td>
                            <td style="padding-right: 20px; text-align: right">Factory Manager</td>
                        </tr>
                    </table>
                </div>
                {{-- <hr style="padding: 0; margin:0; border: 1px solid balck"> --}}
                <div class="conpany_info" style="font-size: 15px;">
                    Head office: High Road, Alamdanga, Chuadanga. <i class="fas fa-tty"></i> 07622-56385, <i class="fas fa-mobile-alt"></i>+8801318-302500,
                        Dhaka Office: House # 14, Road # 3, <br> Block # E, Extended Rupnagar (R/A) Sector # 12, Mirpur, Dhaka-1216.
                        <i class="far fa-envelope"></i> r.tuhin@icloud.com, <i class="fas fa-globe-asia"></i> www.mondolag.com
                </div>
            </footer>
            </div>
            </div>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg==" crossorigin="anonymous"></script>
            <script>
                $(document).ready(function() {
                    window.print();
                });
            </script>
        </body>
    </html>

