<div>
    <div class="form-group mt-8">
        <button type="submit" wire:click.prevent="handle" wire:loading.attr="disabled" class="px-4 py-2 font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple text-sm" style="background: #047481">
            <div wire:loading.remove wire:target="handle">
                Next
            </div>
            <div wire:loading wire:target="handle">
                Processing ...
            </div>
        </button>
    </div>
</div>
