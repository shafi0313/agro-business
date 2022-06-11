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
            <div class="bg_img"><img src="{{asset('images/icons/company_bg.png')}}" alt=""></div>
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
                            {{-- <td>{{ substr($dis, 0, strrpos($dis, " ")) }}</td> --}}
                            <td>{{ $ledger->customer->address }}</td>
                        </tr>
                        {{-- <tr>
                            <td class="text-right" colspan="2">:</td>
                            <td>{{ substr($dis, strrpos($dis, ' ')) }}</td>
                        </tr> --}}
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
            <div class="inv_s">Invoice Summery</div>
            <table class="table table_bordered table-sm invoice_table">
                <thead>
                    <tr>
                        <th style="vertical-align: middle;">SL</th>
                        <th>Name of Product</th>
                        <th>Size</th>
                        <th>Pice/Bag</th>
                        <th>Net Weight</th>
                        <th>Unit Price</th>
                        <th>Total Tk</th>
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
                                    <td class="text-center">{{ preg_replace( '/[^0-9]/', '',  $item->packSize->size ) * $item->quantity }}</td>
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
                    <input type="hidden" id="total_amt" value="{{$getShowInvoices->sum('amt')}}">
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
            <div class="note">Note: {{ $ledger->sampleNote->note }}</div>
            @endisset

            {{-- Invoice Due Table --}}
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
                var a = ['','one ','two ','three ','four ', 'five ','six ','seven ','eight ','nine ','ten ','eleven ','twelve ','thirteen ','fourteen ','fifteen ','sixteen ','seventeen ','eighteen ','nineteen '];
                var b = ['', '', 'twenty','thirty','forty','fifty', 'sixty','seventy','eighty','ninety'];

                function inWords (num) {
                    if ((num = num.toString()).length > 9) return 'overflow';
                    n = ('000000000' + num).substr(-9).match(/^(\d{2})(\d{2})(\d{2})(\d{1})(\d{2})$/);
                    if (!n) return; var str = '';
                    str += (n[1] != 0) ? (a[Number(n[1])] || b[n[1][0]] + ' ' + a[n[1][1]]) + 'crore ' : '';
                    str += (n[2] != 0) ? (a[Number(n[2])] || b[n[2][0]] + ' ' + a[n[2][1]]) + 'lakh ' : '';
                    str += (n[3] != 0) ? (a[Number(n[3])] || b[n[3][0]] + ' ' + a[n[3][1]]) + 'thousand ' : '';
                    str += (n[4] != 0) ? (a[Number(n[4])] || b[n[4][0]] + ' ' + a[n[4][1]]) + 'hundred ' : '';
                    str += (n[5] != 0) ? ((str != '') ? 'and ' : '') + (a[Number(n[5])] || b[n[5][0]] + ' ' + a[n[5][1]]) + 'taka only ' : '';
                    return str;
                }
                var net_amt = Math.round(document.getElementById('net_amt').value)
                document.getElementById('words_net').innerHTML = inWords(net_amt);
            </script>

            <script>
                $(document).ready(function() {
                  window.print();
                });
            </script>
          </body>
        </html>

