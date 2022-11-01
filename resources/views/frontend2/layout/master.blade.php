<!DOCTYPE html>
<html lang="en">
<head>
    @include('frontend.layout.top')
</head>
<body>

    <!-- Nav Bar Start-->
    @include('frontend.layout.header')
    @include('frontend.layout.navigation')
    <!-- Nav Bar End-->

    <!-- PAGE CONTENT BEGINS -->
    @yield('content')

    <!-- Footer -->
    @include('frontend.layout.footer')
    
</body>
</html>
