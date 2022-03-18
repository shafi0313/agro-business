@include('admin.print_layout.challan_header')
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
                        <th>Invoice No</th>
                        <th>Invoice Date</th>
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
                </tr>
                @endforeach
            </table>
            <br>
            <br>
            <br>
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
                            <td style="padding-left: 50px">-----------------------</td>
                            <td style="padding-left: 20px">------------------------------------</td>
                            <td class="text-right">------------------</td>
                        </tr>
                        <tr>
                            <td style="padding-left: 10px">Prepared By</td>
                            <td style="padding-left: 65px">Factory Manager</td>
                            <td style="padding-left: 35px">Customer Signature and Date</td>
                            <td style="padding-right: 8px; text-align: right">Approved By</td>
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
