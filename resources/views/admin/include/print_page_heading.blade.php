<div class="report_header text-center">
    <img src="{{ asset('images/icons/company_bg.png') }}" width="70px" style="display: inline-block;margin:-20px 0 0 0px">
    <div class="report_header_text" style="display: inline-block; width: 280px; border-bottom: 1px solid black; padding-bottom:10px">
        <h1 class="text-center">Mondol Traders</h1>
        <h4 class="text-center">{{ $pageTitle }}</h4>
        @if(!empty($form_date) && !empty($to_date))
        <div style="font-size:18px; text-align:center">Form: {{Carbon\carbon::parse($form_date)->format('d/m/Y')}} To: {{Carbon\carbon::parse($to_date)->format('d/m/Y')}}</div>
        @endif
    </div>
</div>
