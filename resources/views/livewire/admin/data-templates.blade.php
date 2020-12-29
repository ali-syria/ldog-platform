<div>
    @section('title','Data Templates')
    <div class="mb-24">
        <x-components.page-header>
            <x-components.page-title>Data Templates</x-components.page-title>
        </x-components.page-header>

        <x-components.crud-toolbox>
            <x-components.create-button>
                New Data Template
            </x-components.create-button>
        </x-components.crud-toolbox>

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

    <x-components.modal :is-modal-open="$isModalOpen" action="store">
        <x-slot name="title">
            @if($this->isCreateOpertion())
                New Data Template
            @else

            @endif
        </x-slot>
        <x-slot name="body">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 xl:grid-cols-2 gap-4">
                <div class="form-group">
                    <span class="text-gray-700 text-xs font-semibold">Title</span>
                    <x-form.input type="text" name="title" required/>
                </div>
                <div class="form-group">
                    <span class="text-gray-700 text-xs font-semibold">Description</span>
                    <x-form.input type="textarea" name="description" required/>
                </div>
                <div class="form-group">
                    <span class="text-gray-700 text-xs font-semibold">Template Type</span>
                    <x-form.select name="template_type" :items="$this->dataTemplateTypes"  required :lazy-update="true"/>
                    <x-icons.css-spinner-two class="animate-spin" wire:loading wire:target="template_type"/>
                </div>
                <div class="form-group">
                    <span class="text-gray-700 text-xs font-semibold">Data Domain</span>
                    <x-form.select name="data_domain" :items="$this->dataDomains" key="uri" value="label" required/>
                </div>
                <div class="form-group">
                    <span class="text-gray-700 text-xs font-semibold">Export Target</span>
                    <x-form.select name="export_target" :items="$this->exportTargets" key="uri" value="label"  required/>
                </div>
                @if($template_type==\App\Enums\DataTemplateType::DATA_REPORT)
                <div class="form-group">
                    <span class="text-gray-700 text-xs font-semibold">Export Frequency</span>
                    <x-form.select name="report_export_frequency" :items="$this->reportExportFrequencies" key="uri" value="label" required/>
                </div>
                @endif
                <div class="form-group">
                    <span class="text-gray-700 text-xs font-semibold">Data Shape (Shacl-Turtle)</span>
                    <x-form.file live-name="data_shape" name="data_shape"  :url="$dataShapeUrl" :fileName="$dataShapeFileName" mimeType="text/turtle"/>
                </div>
                <div class="form-group">
                    <span class="text-gray-700 text-xs font-semibold">Silk Sls</span>
                    <x-form.file live-name="silk_sls" name="silk_sls"  :url="$silkSlsUrl" :fileName="$silkSlsFileName" mimeType="application/xml"/>
                </div>
            </div>
            @if(!$isValidShape)
                <h2 class="text-2xl mt-4 text-red-700">Data Shape Errors:</h2>
                <ul class="text-red-500">
                    @foreach(optional($this->validationResultReport)->results() ?? [] as $result)
                        <li>{{ $result->getMessage() }}</li>
                    @endforeach
                </ul>
            @endif
        </x-slot>
        <x-slot name="buttons">
            <x-components.save-button live-target="store"/>
        </x-slot>
    </x-components.modal>
</div>
