@extends('layouts.base')

@section('body')
    @stack('body-start')
{{--    justify-center--}}
    <div class="flex flex-col  min-h-screen py-12 bg-gray-50 sm:px-6 lg:px-8">
        <div class="absolute top-0 right-0 mt-4 mr-4">
            @if (Route::has('login'))
                <div class="space-x-4">
                    <a href="{{ route('home') }}" class="font-medium text-indigo-600 hover:text-indigo-500 focus:outline-none focus:underline transition ease-in-out duration-150">Home</a>
                    <a href="{{ route('admin.dashboard') }}" class="font-medium text-indigo-600 hover:text-indigo-500 focus:outline-none focus:underline transition ease-in-out duration-150">Dashboard</a>
                    <a href="{{ route('website.poc.index') }}" class="font-medium text-indigo-600 hover:text-indigo-500 focus:outline-none focus:underline transition ease-in-out duration-150">POC</a>
                    <a href="{{ route('ldog.sparql') }}" class="font-medium text-indigo-600 hover:text-indigo-500 focus:outline-none focus:underline transition ease-in-out duration-150">Sparql</a>
                </div>
            @endif
        </div>
        @yield('content')

    </div>


    @isset($slot)
        {{ $slot }}
    @endisset
@endsection
