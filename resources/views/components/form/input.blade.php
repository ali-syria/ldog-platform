@php
    $langClasses="";
    if($isRtl ?? false)
    {
        $langClasses="rtl";
    }
@endphp
@if($type=="textarea")
    <textarea name="{{ $name }}" id="{{ $id }}" {{ $attributes->merge(['class'=>"form-input mt-1 block w-full $langClasses"]) }}
        wire:model.lazy="{{ $liveName }}"></textarea>
@else
    <input type="{{ $type }}" name="{{ $name }}" id="{{ $id }}"
           {{ $attributes->merge(['class'=>"form-input mt-1 block w-full $langClasses"]) }}
           wire:model.lazy="{{ $liveName }}"
    >
@endif
@unless($withoutErrors)
    @error($liveName)
        <span class="text-xs text-red-600 px-1">{{ $message }}</span>
    @enderror
@endunless
