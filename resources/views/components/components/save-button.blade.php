<button type="submit" class="w-full px-5 py-3 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg sm:w-auto sm:px-4 sm:py-2 active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple" wire:loading.class="opacity-50 cursor-not-allowed" wire:loading.attr="disabled" wire:target="{{ $liveTarget }}">
    <div wire:loading.remove wire:target="{{ $liveTarget }}">
        Save
    </div>
    <div wire:loading wire:target="{{ $liveTarget }}">
        Saving ...
    </div>
</button>
