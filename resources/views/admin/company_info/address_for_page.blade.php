@php
    $companyInfo = \App\Models\CompanyInfo::whereId(1)->first(['name','address','phone','web']);
@endphp
<p style="font-size: 22px;margin:0">{{ config('app.locale')=='en'?setting('app_name'):setting('app_name_b') }}</p>
<p>
    <span>{{ $companyInfo->address }}</span><br>
    <span>Phone: {{ $companyInfo->phone }}</span><br>
    <span>Email: {{ $companyInfo->web }}</span>
</p>
