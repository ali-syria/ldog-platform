@extends('admin.layouts.app',['slot'=>null])

@section('content')
    <div class="mb-24">
        <x-components.page-header>
            <x-components.page-title>Batch Data Import Wizard</x-components.page-title>
        </x-components.page-header>
        <div>
            <div class="mx-4 p-4">
                <div class="flex items-center">
                    <div class="flex items-center @if($step==1) text-white @elseif($step>1) text-teal-600 @else text-gray-500 @endif  relative">
                        <div class="rounded-full {{ $step==1?'bg-teal-600':'' }} transition duration-500 ease-in-out h-12 w-12 py-3 border-2 {{ $step>=1?'border-teal-600':'border-gray-300' }} ">
                            <svg class="w-full h-full" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M15.213 6.639c-.276 0-.546.025-.809.068C13.748 4.562 11.716 3 9.309 3c-2.939 0-5.32 2.328-5.32 5.199 0 .256.02.508.057.756a3.567 3.567 0 0 0-.429-.027C1.619 8.928 0 10.51 0 12.463S1.619 16 3.617 16H8v-4H5.5L10 7l4.5 5H12v4h3.213C17.856 16 20 13.904 20 11.32c0-2.586-2.144-4.681-4.787-4.681z"></path></svg>
                        </div>
                        <div class="absolute top-0 -ml-10 text-center mt-16 w-32 text-xs font-medium uppercase text-teal-600">Uppload CSV</div>
                    </div>
                    <div class="flex-auto border-t-2 transition duration-500 ease-in-out {{ $step>=2?'border-teal-600':'border-gray-300' }}"></div>
                    <div class="flex items-center @if($step==2) text-white @elseif($step>2) text-teal-600 @else text-gray-500 @endif relative">
                        <div class="rounded-full {{ $step==2?'bg-teal-600':'' }} transition duration-500 ease-in-out h-12 w-12 py-3 border-2  {{ $step>=2?'border-teal-600':'border-gray-300' }}">
                            <svg class="w-full h-full" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <line x1="4" y1="6" x2="9.5" y2="6"></line>
                                <line x1="4" y1="10" x2="9.5" y2="10"></line>
                                <line x1="4" y1="14" x2="9.5" y2="14"></line>
                                <line x1="4" y1="18" x2="9.5" y2="18"></line>
                                <line x1="14.5" y1="6" x2="20" y2="6"></line>
                                <line x1="14.5" y1="10" x2="20" y2="10"></line>
                                <line x1="14.5" y1="14" x2="20" y2="14"></line>
                                <line x1="14.5" y1="18" x2="20" y2="18"></line>
                            </svg>
                        </div>
                        <div class="absolute top-0 -ml-10 text-center mt-16 w-32 text-xs font-medium uppercase text-teal-600">Mapping Columns</div>
                    </div>
                    <div class="flex-auto border-t-2 transition duration-500 ease-in-out {{ $step>=3?'border-teal-600':'border-gray-300' }}"></div>
                    <div class="flex items-center @if($step==3) text-white @elseif($step>3) text-teal-600 @else text-gray-500 @endif relative">
                        <div class="rounded-full {{ $step==3?'bg-teal-600':'' }} transition duration-500 ease-in-out h-12 w-12 py-3 border-2 {{ $step>=3?'border-teal-600':'border-gray-300' }}">
                            <svg class="w-full h-full" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M12 0H4a2 2 0 0 0-2 2v4h12V2a2 2 0 0 0-2-2zm2 7h-4v2h4V7zm0 3h-4v2h4v-2zm0 3h-4v3h2a2 2 0 0 0 2-2v-1zm-5 3v-3H6v3h3zm-4 0v-3H2v1a2 2 0 0 0 2 2h1zm-3-4h3v-2H2v2zm0-3h3V7H2v2zm4 0V7h3v2H6zm0 1h3v2H6v-2z"></path>
                            </svg>
                        </div>
                        <div class="absolute top-0 -ml-10 text-center mt-16 w-32 text-xs font-medium uppercase text-gray-500">Normalization</div>
                    </div>
                    <div class="flex-auto border-t-2 transition duration-500 ease-in-out {{ $step>=4?'border-teal-600':'border-gray-300' }}"></div>
                    <div class="flex items-center @if($step==4) text-white @elseif($step>4) text-teal-600 @else text-gray-500 @endif relative">
                        <div class="rounded-full {{ $step==4?'bg-teal-600':'' }} transition duration-500 ease-in-out h-12 w-12 py-3 border-2 {{ $step>=4?'border-teal-600':'border-gray-300' }}">
                            <svg class="w-full h-full" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M7.859 14.691l-.81.805a1.814 1.814 0 0 1-2.545 0 1.762 1.762 0 0 1 0-2.504l2.98-2.955c.617-.613 1.779-1.515 2.626-.675a.992.992 0 1 0 1.397-1.407c-1.438-1.428-3.566-1.164-5.419.675l-2.98 2.956A3.719 3.719 0 0 0 2 14.244a3.72 3.72 0 0 0 1.108 2.658 3.779 3.779 0 0 0 2.669 1.096c.967 0 1.934-.365 2.669-1.096l.811-.805a.988.988 0 0 0 .005-1.4.995.995 0 0 0-1.403-.006zm9.032-11.484c-1.547-1.534-3.709-1.617-5.139-.197l-1.009 1.002a.99.99 0 1 0 1.396 1.406l1.01-1.001c.74-.736 1.711-.431 2.346.197.336.335.522.779.522 1.252s-.186.917-.522 1.251l-3.18 3.154c-1.454 1.441-2.136.766-2.427.477a.99.99 0 1 0-1.396 1.406c.668.662 1.43.99 2.228.99.977 0 2.01-.492 2.993-1.467l3.18-3.153A3.732 3.732 0 0 0 18 5.866a3.726 3.726 0 0 0-1.109-2.659z"></path></svg>
                        </div>
                        <div class="absolute top-0 -ml-10 text-center mt-16 w-32 text-xs font-medium uppercase text-gray-500">Reconciliation</div>
                    </div>
                    <div class="flex-auto border-t-2 transition duration-500 ease-in-out {{ $step>=5?'border-teal-600':'border-gray-300' }}"></div>
                    <div class="flex items-center @if($step==5) text-white @elseif($step>5) text-teal-600 @else text-gray-500 @endif relative">
                        <div class="rounded-full {{ $step==5?'bg-teal-600':'' }} transition duration-500 ease-in-out h-12 w-12 py-3 border-2 {{ $step>=5?'border-teal-600':'border-gray-300' }}">
                            <svg class="w-full h-full" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!-- Font Awesome Free 5.15.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free (Icons: CC BY 4.0, Fonts: SIL OFL 1.1, Code: MIT License) --><path d="M139.61 35.5a12 12 0 0 0-17 0L58.93 98.81l-22.7-22.12a12 12 0 0 0-17 0L3.53 92.41a12 12 0 0 0 0 17l47.59 47.4a12.78 12.78 0 0 0 17.61 0l15.59-15.62L156.52 69a12.09 12.09 0 0 0 .09-17zm0 159.19a12 12 0 0 0-17 0l-63.68 63.72-22.7-22.1a12 12 0 0 0-17 0L3.53 252a12 12 0 0 0 0 17L51 316.5a12.77 12.77 0 0 0 17.6 0l15.7-15.69 72.2-72.22a12 12 0 0 0 .09-16.9zM64 368c-26.49 0-48.59 21.5-48.59 48S37.53 464 64 464a48 48 0 0 0 0-96zm432 16H208a16 16 0 0 0-16 16v32a16 16 0 0 0 16 16h288a16 16 0 0 0 16-16v-32a16 16 0 0 0-16-16zm0-320H208a16 16 0 0 0-16 16v32a16 16 0 0 0 16 16h288a16 16 0 0 0 16-16V80a16 16 0 0 0-16-16zm0 160H208a16 16 0 0 0-16 16v32a16 16 0 0 0 16 16h288a16 16 0 0 0 16-16v-32a16 16 0 0 0-16-16z"></path></svg>
                        </div>
                        <div class="absolute top-0 -ml-10 text-center mt-16 w-32 text-xs font-medium uppercase text-gray-500">Validation</div>
                    </div>
                    <div class="flex-auto border-t-2 transition duration-500 ease-in-out {{ $step>=6?'border-teal-600':'border-gray-300' }}"></div>
                    <div class="flex items-center @if($step==6) text-white @elseif($step>6) text-teal-600 @else text-gray-500 @endif relative">
                        <div class="rounded-full {{ $step==6?'bg-teal-600':'' }} transition duration-500 ease-in-out h-12 w-12 py-3 border-2 {{ $step>=6?'border-teal-600':'border-gray-300' }}">
                            <svg class="w-full h-full" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.967 8.193L5 13h3v6h4v-6h3L9.967 8.193zM18 1H2C.9 1 0 1.9 0 3v12c0 1.1.9 2 2 2h4v-2H2V6h16v9h-4v2h4c1.1 0 2-.9 2-2V3c0-1.1-.9-2-2-2zM2.5 4.25a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5zm2 0a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5zM18 4H6V3h12.019L18 4z"></path></svg>
                        </div>
                        <div class="absolute top-0 -ml-10 text-center mt-16 w-32 text-xs font-medium uppercase text-gray-500">Publishing</div>
                    </div>
                </div>
            </div>
            <div class="mt-10 p-2 w-full bg-white shadow-sm border-t-2">
                @isset($slot)
                    {{ $slot }}
                @endisset
            </div>
        </div>
    </div>
@endsection
