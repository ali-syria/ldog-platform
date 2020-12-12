<div  x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 z-30 flex bg-black bg-opacity-50 sm:items-start sm:justify-center h-auto mh-100 {{  $isModalOpen? '':'hidden' }}" style="    position: absolute;
    top: 0;
    right: 0;
    bottom: 0;
    overflow-x: hidden;
    overflow-y: auto;">
    <!-- Modal -->
    <div x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0 transform translate-y-1/2" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0  transform translate-y-1/2" class="w-full px-6 py-4  bg-white rounded-t-lg dark:bg-gray-800 sm:rounded-lg m-0 sm:max-w-xl md:max-w-4xl {{  $isModalOpen? '':'hidden' }}" role="dialog" id="modal" style="margin-top:30px;margin-bottom:10px">
        <!-- Remove header if you don't want a close icon. Use modal body to place modal tile. -->
        <header class="flex justify-between">
            <p class="mb-2 text-lg font-semibold text-gray-700 dark:text-gray-300">
                {{ $title }}
            </p>
            <button type="button" class="inline-flex items-center justify-center w-6 h-6 text-gray-400 transition-colors duration-150 rounded dark:hover:text-gray-200 hover: hover:text-gray-700" aria-label="close" wire:click.prevent="closeModal">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20" role="img" aria-hidden="true">
                    <path d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" fill-rule="evenodd"></path>
                </svg>
            </button>
        </header>
        <form wire:submit.prevent="{{ $action }}" enctype="multipart/form-data">
            <div class="mt-0 mb-6 pt-4">
                {{ $body }}
            </div>
            <footer class="flex flex-col items-center justify-end px-6 py-3 -mx-6 -mb-4 space-y-4 sm:space-y-0 sm:space-x-6 sm:flex-row bg-gray-50 dark:bg-gray-800">
                <button type="button" wire:click.prevent="closeModal" class="w-full px-5 py-3 text-sm font-medium leading-5 text-white text-gray-700 transition-colors duration-150 border border-gray-300 rounded-lg dark:text-gray-400 sm:px-4 sm:py-2 sm:w-auto active:bg-transparent hover:border-gray-500 focus:border-gray-500 active:text-gray-500 focus:outline-none focus:shadow-outline-gray">
                    Cancel
                </button>
                {{ $buttons }}
            </footer>
        </form>
    </div>
</div>
