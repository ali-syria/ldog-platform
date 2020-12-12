<div x-data='{active:@json($active)}' wire:ignore.self>
    <ul class="flex border-b">
        {{ $links }}
    </ul>
    <div>
        {{ $panes }}
    </div>
</div>
