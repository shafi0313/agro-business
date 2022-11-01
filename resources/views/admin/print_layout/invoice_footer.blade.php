
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
                    <td style="padding-left: 205px">------------------</td>
                    <td class="text-right">------------------------------------</td>
                </tr>
                <tr>
                    <td style="padding-left: 12px">Prepared By</td>
                    <td style="padding-left: 220px">Delivered By</td>
                    <td style="padding-left: 224px">Customer Signature and Date</td>
                </tr>
            </table>
        </div>
        {{-- <hr style="padding: 0; margin:0; border: 1px solid balck"> --}}
        <div class="conpany_info" style="font-size: 15px;">
            {{ setting('inv_footer') }}
            {{-- Head office: High Road, Alamdanga, Chuadanga. <i class="fas fa-tty"></i> 07622-56385, <i class="fas fa-mobile-alt"></i>+8801318-302500,
                Dhaka Office: House # 14, Road # 3, <br> Block # E, Extended Rupnagar (R/A) Sector # 12, Mirpur, Dhaka-1216.
                <i class="far fa-envelope"></i> r.tuhin@icloud.com, <i class="fas fa-globe-asia"></i> www.mondolag.com --}}
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
