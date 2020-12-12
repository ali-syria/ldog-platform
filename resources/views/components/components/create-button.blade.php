<div>
    <button wire:click="create" wire:loading.attr="disabled" wire:target="create,edit" class="px-4 py-2 font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple text-sm">{{ $slot }}</button>
</div>
