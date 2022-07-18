@php
    $companyInfo = \App\Models\CompanyInfo::whereId(1)->first(['name','favicon']);
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<title>@yield('title') | {{$companyInfo->name}}</title>
	<meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
    <meta content='{{csrf_token()}}' name='csrf-token' />
	<link rel="icon" href="{{ asset('files/images/icon/'.$companyInfo->favicon) }}" type="image/x-icon"/>

	<!-- Fonts and icons -->
	<script src="{{ asset('backend/assets/js/plugin/webfont/webfont.min.js') }}"></script>
	<script>
		WebFont.load({
			google: {"families":["Open+Sans:300,400,600,700"]},
			custom: {"families":["Flaticon", "Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands"], urls: ['{{ asset("backend/assets/css/fonts.css") }}']},
			active: function() {
				sessionStorage.fonts = true;
			}
		});
    </script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />

	<!-- CSS Files -->
	<link rel="stylesheet" href="{{ asset('backend/assets/css/bootstrap.min.css') }}">
	<link rel="stylesheet" href="{{ asset('backend/assets/css/azzara.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/css/style.css') }}">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" >

    {{-- For Date Picker --}}
    <link rel="stylesheet" href="{{ asset('backend/assets/datepicker/css/bootstrap-datepicker3.standalone.min.css') }}">
	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css">
    <script src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
</head>
<body>
	<div class="wrapper">
		<div class="main-header" data-background-color="purple">
			<!-- Logo Header -->
			<div class="logo-header">
                <a href="{{ route('admin.dashboard') }}" class="logo"> <h3 class="display:4 text-light mt-3">{{ $companyInfo->name }}</h3>
				</a>
				<button class="navbar-toggler sidenav-toggler ml-auto" type="button" data-toggle="collapse" data-target="collapse" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon">
						<i class="fa fa-bars"></i>
					</span>
				</button>
				<button class="topbar-toggler more"><i class="fa fa-ellipsis-v"></i></button>
				<div class="navbar-minimize">
					<button class="btn btn-minimize btn-rounded">
						<i class="fa fa-bars"></i>
					</button>
				</div>
			</div>
			<!-- End Logo Header -->
            {{-- Header --}}
            @include('admin.layout.header')
            {{-- End Header --}}
		</div>

		{{-- Navigation --}}
        @include('admin.layout.navigation')
        {{-- End Navigation --}}
        @yield('content')
	</div>
</div>

<!--   Core JS Files   -->
<script src="{{ asset('backend/assets/js/core/jquery.3.2.1.min.js') }}"></script>
<script src="{{ asset('backend/assets/js/core/popper.min.js') }}"></script>
<script src="{{ asset('backend/assets/js/core/bootstrap.min.js') }}"></script>
<!-- jQuery UI -->
<script src="{{ asset('backend/assets/js/plugin/jquery-ui-1.12.1.custom/jquery-ui.min.js') }}"></script>
<script src="{{ asset('backend/assets/js/plugin/jquery-ui-touch-punch/jquery.ui.touch-punch.min.js') }}"></script>

<!-- jQuery Scrollbar -->
<script src="{{ asset('backend/assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js') }}"></script>

<!-- Moment JS -->
<script src="{{ asset('backend/assets/js/plugin/moment/moment.min.js') }}"></script>

<!-- jQuery Sparkline -->
<script src="{{ asset('backend/assets/js/plugin/jquery.sparkline/jquery.sparkline.min.js') }}"></script>

<!-- Azzara JS -->
<script src="{{ asset('backend/assets/js/ready.min.js') }}"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
@include('sweetalert::alert')

<script>
    $("form").on('submit', function(e){
        $(this).find('button[type="submit"]').attr('disabled', 'disabled');
        $(this).find('input[type="submit"]').attr('disabled', 'disabled');
    });
</script>
@stack('custom_scripts')

</body>
</html>

