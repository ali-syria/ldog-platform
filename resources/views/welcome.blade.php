@extends('layouts.app')

@section('content')
    <div class="flex items-center justify-center">
        <div class="flex flex-col justify-around">
            <div class="space-y-6">
                <a href="{{ route('home') }}">
                    <x-logo class="w-auto h-auto mx-auto text-indigo-600" />
                </a>
            </div>
        </div>
    </div>
@endsection
