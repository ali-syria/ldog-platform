<div>
    @section('title','Ontologies')
    <div class="mb-24">
        <x-components.page-header>
            <x-components.page-title>Ontologies</x-components.page-title>
        </x-components.page-header>

        <x-components.crud-toolbox>
            <x-components.create-button>
                New Ontology
            </x-components.create-button>
        </x-components.crud-toolbox>

        <x-components.data-table class="lg:w-full">
            <x-slot name="head">
                <tr>
                    <x-components.data-table-th class="text-left">Prefix</x-components.data-table-th>
                    <x-components.data-table-th class="text-left">Namespace</x-components.data-table-th>
                    <x-components.data-table-th class="text-left">Data Domain</x-components.data-table-th>
                    <x-components.data-table-th class="text-left w-2/6">Description</x-components.data-table-th>
                    <x-components.data-table-th class="text-left">Actions</x-components.data-table-th>
                </tr>
            </x-slot>
            <x-slot name="body">
                @foreach($this->ontologies as $ontology)
                    <tr data-itemId="{{{ $ontology->getUri() }}}" class="hover:bg-gray-50"  wire:key="{{ 'tr'.$loop->index }}">

                        <x-components.data-table-td>
                            {{ $ontology->getPrefix() }}
                        </x-components.data-table-td>

                        <x-components.data-table-td>
                            {{ $ontology->getNamespace() }}
                        </x-components.data-table-td>

                        <x-components.data-table-td>
                            {{ $ontology->getDataDomain()->label }}
                        </x-components.data-table-td>

                        <x-components.data-table-td>
                            {{ $ontology->getDescription() }}
                        </x-components.data-table-td>

                        <x-components.data-table-td>
                            <a wire:click.prevent="download('{{ $ontology->getPrefix() }}','{{ $ontology->getUri() }}')" href="" class="text-purple-500 hover:text-indigo-900">Download</a>
                        </x-components.data-table-td>
                    </tr>
                @endforeach
            </x-slot>
        </x-components.data-table>
    </div>

    <x-components.modal :is-modal-open="$isModalOpen" action="store">
        <x-slot name="title">
            @if($this->isCreateOpertion())
                New Ontology
            @else

            @endif
        </x-slot>
        <x-slot name="body">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 xl:grid-cols-2 gap-4">
                <div class="form-group">
                    <span class="text-gray-700 text-xs font-semibold">Prefix</span>
                    <x-form.input type="text" name="prefix" required/>
                </div>
                <div class="form-group">
                    <span class="text-gray-700 text-xs font-semibold">Namespace</span>
                    <x-form.input type="url" name="namespace" required/>
                </div>
                <div class="form-group">
                    <span class="text-gray-700 text-xs font-semibold">Description</span>
                    <x-form.input type="textarea" name="description" required/>
                </div>
                <div class="form-group">
                    <span class="text-gray-700 text-xs font-semibold">Data Domain</span>
                    <x-form.select name="data_domain" :items="$this->dataDomains" key="uri" value="label" required/>
                </div>
                <div class="form-group">
                    <span class="text-gray-700 text-xs font-semibold">Source</span>
                    <x-form.select name="source" :items="$this->rdfSources" required :lazy-update="true"/>
                </div>
                <x-icons.css-spinner-two class="animate-spin" wire:loading wire:target="source"/>
                @if($source==\App\Enums\RdfSource::URL)
                <div class="form-group">
                    <span class="text-gray-700 text-xs font-semibold">Ontology (URL)</span>
                    <x-form.input type="url" name="url" required/>
                </div>
                @endif

                @if($source==\App\Enums\RdfSource::TEXT)
                <div class="form-group">
                    <span class="text-gray-700 text-xs font-semibold">Ontology (Turtle Text)</span>
                    <x-form.input type="textarea" name="rdf_text" rows="10" required/>
                </div>
                @endif

                @if($source==\App\Enums\RdfSource::FILE)
                <div class="form-group">
                    <span class="text-gray-700 text-xs font-semibold">Ontology (Turtle File)</span>
                    <x-form.file live-name="rdf_file" name="rdf_file" rows="10" required :url="$fileUrl" :fileName="$fileName" mimeType="text/turtle"/>
                </div>
                @endif
            </div>
        </x-slot>
        <x-slot name="buttons">
            <x-components.save-button live-target="store"/>
        </x-slot>
    </x-components.modal>
</div>
