<div>
    @section('title','Data Collection Imports')
    <div class="mb-24">
        <x-components.page-header>
            <x-components.page-title>Data Collection Imports</x-components.page-title>
        </x-components.page-header>

        <x-components.crud-toolbox>
            <a href="{{ route('admin.dataCollections.wizard') }}" class="px-4 py-2 font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple text-sm">New Import</a>
        </x-components.crud-toolbox>
    </div>
</div>
