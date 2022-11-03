@php
    $companyInfo = \App\Models\CompanyInfo::whereId(1)->first(['name','address','phone','web']);
@endphp
<p style="font-size: 22px;margin:0">{{ config('app.locale')=='en'?setting('app_name'):setting('app_name_b') }}</p>
<p>
    <span>{{ setting('front_address') }}</span><br>
    <span>Phone: {{ setting('phone1') }}</span><br>
    <span>Email: {{ setting('app_url') }}</span>
</p>
