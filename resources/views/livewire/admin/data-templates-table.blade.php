<div>
    <x-components.data-table class="lg:w-full">
        <x-slot name="head">
            <tr>
                <x-components.data-table-th class="text-left">Title</x-components.data-table-th>
                <x-components.data-table-th class="text-left">Type</x-components.data-table-th>
                <x-components.data-table-th class="text-left">Data Domain</x-components.data-table-th>
                <x-components.data-table-th class="text-left">Export Target</x-components.data-table-th>
                <x-components.data-table-th class="text-left">Export Frequency</x-components.data-table-th>
                <x-components.data-table-th class="text-left">Description</x-components.data-table-th>
                <x-components.data-table-th class="text-left">Data Shape</x-components.data-table-th>
                <x-components.data-table-th class="text-left">Silk SLS</x-components.data-table-th>
                {{--                    <x-components.data-table-th class="text-left">Actions</x-components.data-table-th>--}}
            </tr>
        </x-slot>
        <x-slot name="body">
            @foreach($this->dataTemplates as $dataTemplate)
                <tr data-itemId="{{{ $dataTemplate->uri }}}" class="hover:bg-gray-50"  wire:key="{{ 'tr'.$loop->index }}">

                    <x-components.data-table-td>
                        {{ $dataTemplate->label }}
                    </x-components.data-table-td>

                    <x-components.data-table-td>
                        @if($dataTemplate instanceof \AliSyria\LDOG\TemplateBuilder\DataCollectionTemplate)
                            {{ \App\Enums\DataTemplateType::getDescription(\App\Enums\DataTemplateType::DATA_COLLECTION) }}
                        @elseif($dataTemplate instanceof \AliSyria\LDOG\TemplateBuilder\ReportTemplate)
                            {{ \App\Enums\DataTemplateType::getDescription(\App\Enums\DataTemplateType::DATA_REPORT) }}
                        @endif
                    </x-components.data-table-td>

                    <x-components.data-table-td>
                        {{ $dataTemplate->dataDomain->label }}
                    </x-components.data-table-td>

                    <x-components.data-table-td>
                        {{ $dataTemplate->dataExporterTarget->label }}
                    </x-components.data-table-td>


                    <x-components.data-table-td>
                        @if($dataTemplate instanceof \AliSyria\LDOG\TemplateBuilder\ReportTemplate)
                            {{ data_get($dataTemplate,'exportFrequency.label') }}
                        @endif
                    </x-components.data-table-td>

                    <x-components.data-table-td>
                        {{ $dataTemplate->description }}
                    </x-components.data-table-td>

                    <x-components.data-table-td>
                        <a wire:click.prevent="downloadShapeFile('{{ $dataTemplate->dataShape->getUri() }}','{{ $dataTemplate->label }}')" href="" class="text-purple-500 hover:text-indigo-900">Download</a>
                    </x-components.data-table-td>
                    <x-components.data-table-td>
                        @if($dataTemplate->silkLslSpecs)
                            <a wire:click.prevent="downloadSlsFile('{{ base64_encode($dataTemplate->silkLslSpecs) }}','{{ $dataTemplate->label }}')" href="" class="text-purple-500 hover:text-indigo-900">Download</a>
                        @endif
                    </x-components.data-table-td>
                </tr>
            @endforeach
        </x-slot>
    </x-components.data-table>
</div>
