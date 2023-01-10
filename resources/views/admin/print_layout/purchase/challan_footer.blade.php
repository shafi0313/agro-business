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
                <td style="padding-left: 20px">------------------</td>
                <td class="text-right">------------------------------------</td>
            </tr>
            <tr>
                <td style="padding-left: 10px">Prepared By</td>
                <td style="padding-left: 65px">Factory Manager</td>
                <td style="padding-left: 35px">Delivered By</td>
                <td style="padding-right: 8px; text-align: right">Customer Signature and Date</td>
            </tr>
        </table>
    </div>
    {{-- <hr style="padding: 0; margin:0; border: 1px solid balck"> --}}
    <div class="conpany_info" style="font-size: 15px;">
        {{-- <p>
            Head office: High Road, Alamdanga, Chuadanga. <i class="fas fa-tty"></i> 07622-56385, <i class="fas fa-mobile-alt"></i>+8801318-302500,
                Dhaka Office: House # 14, Road # 3, <br> Block # E, Extended Rupnagar (R/A) Sector # 12, Mirpur, Dhaka-1216.
                <i class="far fa-envelope"></i> r.tuhin@icloud.com, <i class="fas fa-globe-asia"></i> www.mondolag.com
        </p> --}}
        {!! setting('inv_footer') !!}
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
