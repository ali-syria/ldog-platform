
<div class="w-full">
    <div class="w-full max-w-2xl   bg-white rounded-lg">
        <div class="">
            <div>
                <p class="uppercase text-bold">
                <div class="flex bg-grey-lighter">
                    <label class="w-64 flex flex-col items-center px-4 py-4 bg-white text-blue  shadow-sm tracking-wide uppercase border border-blue cursor-pointer">
                        <svg class="w-8 h-8" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <path d="M16.88 9.1A4 4 0 0 1 16 17H5a5 5 0 0 1-1-9.9V7a3 3 0 0 1 4.52-2.59A4.98 4.98 0 0 1 17 8c0 .38-.04.74-.12 1.1zM11 11h3l-4-4-4 4h3v3h2v-3z" />
                        </svg>
                        <span class="mt-2 text-base leading-normal">Select a file</span>
                        <span wire:loading wire:target="{{ $liveName }}" class="block text-indigo-300 mt-2">Uploading ...</span>
                        <input type="file" name="{{ $liveName }}"  id="{{ $liveName }}" {{ $attributes->merge(['class'=>'hidden'])  }}  wire:model.defer="{{ $liveName }}" accept="{{ $mimeType }}">
                    </label>
                </div>
                @error($liveName)
                <p class="text-xs text-red-600 px-1">{{ $message }}</p>
                @enderror
            </div>
            @if($url)
                <a href="{{ $url }}">
                    <svg class="w-16 h-16" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                </a>
                <span class="text-sm">{{ $fileName }}</span>
            @endif
        </div>
    </div>
</div>
