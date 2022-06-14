
<style>
    /* .footer_signature {
        padding: 15px 15px 0 15px;
    } */
    .footer_signature div {
        border-bottom: 1px solid black;
    }

    /* .footer_signature_area{
        position: fixed;
        bottom: 0;
    } */

    @page {
        size: A4;
        margin: 11mm 11mm 18mm 11mm;
    }

    @media print {
        .footer_signature .p {
            position: fixed;
            bottom: 0;
            width: 200px;
            left: 0;
            text-align: center;
        }

        .footer_signature .a {
            position: fixed;
            bottom: 0;
            width: 200px;
            right: 0;
            text-align: center;
        }
    }
</style>
<div id="footer_signature_area" style="display: none">
    <div class="footer_signature">
        <div class="p">Prepared by</div>
        <div  class="a">Authorized by</div>
    </div>
</div>
