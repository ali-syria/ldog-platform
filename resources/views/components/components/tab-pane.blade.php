<div x-show='active==@json($id)' {{ $attributes->merge(['class'=>'p-1']) }} wire:ignore.self>
    {{ $content }}
</div>
