<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>{{ env('APP_NAME') }} | @yield('title')</title>
    <meta content="Document Control" name="description">
    <meta content="Document Control" name="keywords">

    <link href="{{ asset('assets/img/favicon.png') }}" rel="icon">
    <link href="{{ asset('assets/img/apple-touch-icon.png') }}" rel="apple-touch-icon">

    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">

    <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/remixicon/remixicon.css') }}" rel="stylesheet">

    {{-- Custom CSS File --}}
    @yield('styles')

    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/js/app.js'])

    <script type="module">
        const userId = @json(auth()->id());
        console.log(`Mendengarkan channel notifications.${userId}`);

        // window.Echo.channel(`notifications.${userId}`)
        //     .listen('notifications', (event) => {
        //         console.log(event);
        //     });
        // Pusher.logToConsole = true;
        // var pusher = new Pusher('{{ env('PUSHER_APP_KEY') }}', {
        //     cluster: 'ap1'
        // });

        // var channel = pusher.subscribe(`notifications.${userId}`);
        // channel.bind('notifications', function(event) {
        //     console.log(event)
        // });
    </script>
</head>

<body>
    @include('sections.header')

    @include('sections.sidebar')

    <main id="main" class="main">

        @include('sections.breadcrumb', ['breadcrumbs' => $breadcrumbs ?? []])

        @yield('content')

    </main><!-- End #main -->

    @include('sections.footer')

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center">
        <i class="bi bi-arrow-up-short"></i>
    </a>

    <!-- Vendor JS Files -->
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    {{-- Custom JS File --}}
    @yield('scripts')

    {{-- Pusher --}}
    {{-- <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/laravel-echo/1.11.1/echo.iife.min.js"></script> --}}
    <script>
        // const userId = @json(auth()->id());
        // console.log(`Mendengarkan channel notifications.${userId}`);

        // Pusher.logToConsole = true;
        // var pusher = new Pusher('{{ env('PUSHER_APP_KEY') }}', {
        //     cluster: 'ap1'
        // });

        // var channel = pusher.subscribe(`notifications.${userId}`);
        // channel.bind('notifications', function(event) {
        //     console.log(event)
        // });
        // const echo = new Echo({
        //     broadcaster: 'pusher',
        //     key: "{{ env('PUSHER_APP_KEY') }}",
        //     cluster: "{{ env('PUSHER_APP_CLUSTER') }}",
        //     forceTLS: true,
        // });

        // echo.channel(`notifications.${userId}`)
        //     .listen('notifications', (event) => {
        //         console.log(event.message); // Tampilkan notifikasi di console atau di UI
        //         alert(`Notifikasi Baru: ${event.message}`);
        //     });
    </script>

    <!-- Template Main JS File -->
    <script src="{{ asset('assets/js/main.js') }}"></script>
</body>

</html>
