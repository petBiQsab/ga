<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Projektové Portfólio') }}</title>
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Scripts -->
    @viteReactRefresh
    @vite(['resources/sass/app.scss', 'resources/js/app.ts'])
</head>
<body>
    <main>
        <!-- React root -->
        <div id="root"></div>
        @yield('content')

    </main>
</body>
<script>
    // Pass data React
    let app = {
        routeSegments: @json(request()->segments()),
        routeQuery: @json(request()->query()),
        user: null
    };
    @if(@isset($userInfoData))
        app.user = @json($userInfoData);
    @endif
    @if(@isset($metadata))
        const routeMeta = @json($metadata)
    @else
        const routeMeta = {}
    @endif
</script>
</html>
