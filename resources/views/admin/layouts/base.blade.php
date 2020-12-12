<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" :class="{ 'theme-dark': dark }" x-data="data()">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        @hasSection('title')

            <title>@yield('title') - {{ config('app.name') }}</title>
        @else
            <title>{{ config('app.name') }}</title>
        @endif

        <!-- Favicon -->
		<link rel="shortcut icon" href="{{ url(asset('logo.svg')) }}">

        <!-- Fonts -->
        <link rel="stylesheet" href="https://rsms.me/inter/inter.css">

        <!-- Styles -->
{{--        <link rel="stylesheet" href="{{ url(mix('css/app.css')) }}">--}}
        <link rel="stylesheet" href="{{ mix('css/admin/app.css') }}" />
        @livewireStyles

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link
            href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap"
            rel="stylesheet"
        />

{{--        <link--}}
{{--            rel="stylesheet"--}}
{{--            href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.css"--}}
{{--        />--}}
{{--        <script--}}
{{--            src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"--}}

{{--        ></script>--}}

        @stack('css-links')
        @stack('css-scripts')
    </head>

    <body>
        @yield('body')


        @livewireScripts
        <script src="{{ url(mix('js/admin/app.js')) }}"></script>
        <script src="{{ mix('js/admin/scripts.js') }}" ></script>
        @stack('js-links')
        @stack('js-scripts')

        @stack('modals')
    </body>
</html>
