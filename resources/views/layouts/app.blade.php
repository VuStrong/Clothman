<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>

    @hasSection ('description')
        <meta name="description" content="@yield('description')">
        <meta property="og:description" content="@yield('description')">
    @else
        <meta name="description" content="Clothman chuyên thời trang nam và các sản phẩm chăm sóc cá nhân nam giới chất lượng, giá tốt.">
        <meta property="og:description" content="Clothman chuyên thời trang nam và các sản phẩm chăm sóc cá nhân nam giới chất lượng, giá tốt.">
    @endif

    @hasSection ('image')
        <meta property="og:image" content="@yield('image')">
    @endif

    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">
    <link rel="mask-icon" href="/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @yield('css')
</head>

<body>
    {{-- Header --}}
    @include('includes.header')

    <main>
        @yield('content')
    </main>

    {{-- Footer --}}
    @include('includes.footer')

    {{-- Scripts --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    
    {{-- Notification --}}
    @include('includes.notification')

    {{-- Script for display cart quantity in header --}}
    <script>
        $(function () {
            updateCartQuantityInHeader();
        });

        function updateCartQuantityInHeader() {
            $.get("{{ route('api.cart.count') }}", function(data, status){
                if (status === 'success') {
                    $('header .cart-quantity').html(data.count);
                }
            }); 
        }
    </script>

    @yield('scripts')
</body>
</html>