@extends('admin.layouts.base')

@section('body')
    <div
        class="flex h-screen bg-purple-50 dark:bg-gray-900"
        :class="{ 'overflow-hidden': isSideMenuOpen }"
    >
        @include('admin.layouts.partials.sidebar')
        <div class="flex flex-col flex-1 w-full">
            @include('admin.layouts.partials.navbar')
            <main class="h-full overflow-y-auto">
                <div class="container px-6 mx-auto grid">
                    @yield('content')
                </div>
            </main>
        </div>
    </div>
@endsection
