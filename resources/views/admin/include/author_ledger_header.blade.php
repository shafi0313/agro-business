<div class="col-md-12">
    <div class="report_header text-center">
        <img src="{{ asset('images/icons/company_bg.png') }}" width="70px" style="display: inline-block;margin:-141px 0 0 0px">
        <div class="report_header_text" style="display: inline-block; width: 485px; border-bottom: 1px solid black;">
            <h2><strong>Name: </strong>{{$authorInfo->name}}</h2>
            <p>
                <span><strong>ID: </strong>{{$authorInfo->tmm_so_id}}</span><br>
                <span><strong>Designation: </strong>{{$employeeInfo->designation->name}}</span><br>
                <span><strong>Job Location: </strong>{{$employeeInfo->job_loc}}</span><br>
                <span><strong>Phone: </strong>{{$authorInfo->phone}}</span><br>
                <span><strong>Address: </strong>{{$authorInfo->address}}</span>
                @if(!empty($form_date) && !empty($to_date))
                 <div style="font-size:18px; text-align:center">Form: {{ Carbon\carbon::parse($form_date)->format('d/m/Y') }} To: {{Carbon\carbon::parse($to_date)->format('d/m/Y') }}</div>
                @endif
            </p>

        </div>
    </div>
</div>
<style>
    p{padding: 0 !important; margin: 0 !important}
</style>
