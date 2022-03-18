@php
    $companyInfo = \App\Models\CompanyInfo::whereId(1)->first(['name','address','phone','web']);
@endphp
<p style="font-size: 22px;margin:0">{{ $companyInfo->name }}</p>
<p>
    <span>{{ $companyInfo->address }}</span><br>
    <span>Phone: {{ $companyInfo->phone }}</span><br>
    <span>Email: {{ $companyInfo->web }}</span>
</p>
