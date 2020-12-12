<div {{ $attributes->merge(['class'=>'toolbox mb-2 flex justify-between']) }}>
    {{ $slot }}
    <x-icons.css-spinner-two class="animate-spin" wire:loading/>
</div>
