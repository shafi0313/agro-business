<style>

    @media print{
    #footer_signature_area{
        /* position:absolute; */
    /* margin-left: 38%;
    margin-right: 38%; */
    /* bottom:-25pc; */
     }
}
    .footer_signature {
        padding: 15px 15px 0 15px;
    }
    .footer_signature div {
        border-top: 1px solid black;
    }
    @page {
        size: A4;
        margin: 11mm 11mm 18mm 11mm;
    }

    @media print {
        .footer_signature .p {
            position: fixed;
            bottom: 0;
            width: 100px;
            left: 20px;
            text-align: center;
        }
        .footer_signature .f {
            position: fixed;
            bottom: 0;
            width: 120px;
            left: 400px;
            text-align: center;
        }

        .footer_signature .a {
            position: fixed;
            bottom: 0;
            width: 100px;
            right: 20px;
            text-align: center;
        }
    }
</style>
{{-- <div id="footer_signature_area" style="display: none"> --}}
<div id="footer_signature_area" style="display: none">
    <div class="footer_signature">
        <div class="p">Prepared by</div>
        <div class="f">Factory Manager</div>
        <div class="a">Authorized by</div>
    </div>
</div>

