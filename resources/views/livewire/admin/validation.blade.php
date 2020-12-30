<div>
    @if($hasFailedRecord)
        <form wire:submit.prevent="handle">
            <table class="table-fixed border-collapse w-9/12">
                <thead>
                <tr>
                    <th class="w-3/12 p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell">Column</th>
                    <th class="w-9/12 p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell">Value</th>
                </tr>
                </thead>
                <tbody>
                @foreach($this->predicates as $predicate)
                    @php $failedResourceProperties=collect($this->failedResource->getProperties()); @endphp
                    <tr  class="bg-white lg:hover:bg-gray-100 flex lg:table-row flex-row lg:flex-row flex-wrap lg:flex-no-wrap mb-10 lg:mb-0">
                        <td  x-data="{ tooltip: false }" x-on:mouseover="tooltip = true" x-on:mouseleave="tooltip = false" class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b block lg:table-cell relative lg:static">
                            <div class="relative" x-cloak x-show.transition.origin.top="tooltip">
                                <div class="absolute top-0 z-10 w-32 p-2 -mt-1 text-sm leading-tight text-white transform  -translate-y-full bg-orange-500 rounded-lg shadow-lg">
                                    {{ $predicate->description }}
                                </div>
                                <svg class="absolute z-10 w-6 h-6 text-orange-500 transform -translate-y-3 fill-current stroke-current" width="8" height="8">
                                    <rect x="12" y="-10" width="8" height="8" transform="rotate(45)" />
                                </svg>
                            </div>
                            {{ $predicate->name }}
                        </td>
                        <td class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b block lg:table-cell relative lg:static">
                            @php $object=$failedResourceProperties->filter(fn($value,$key)=>$key==$predicate->uri)->first(); @endphp
                            @if(!$object)
                                @continue
                            @endif
                            @if($predicate==AliSyria\LDOG\UriBuilder\UriBuilder::PREFIX_RDFS.'label' || $predicate=='@type')
                                @continue;
                            @endif

                            @if($object instanceof ML\JsonLD\TypedValue)
                                <x-form.input type="text" name="resourceProperties[{{ base64_encode($predicate->uri) }}]" live-name="resourceProperties.{{ base64_encode($predicate->uri) }}"/>
                            @else
                                <x-form.select name="resourceProperties[{{ base64_encode($predicate->uri) }}]" live-name="resourceProperties.{{ base64_encode($predicate->uri) }}" :items="$this->shapeObjectPredicateClassResources->where('predicate',$predicate->uri)->first()->resources ?? []" key="uri" value="label" required />
                            @endif
                            <span>Occurences</span> {{ $this->getValueOccurences($predicate,) }}
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <div class="form-group mt-8">
                <button type="submit" wire:click.prevent="handle" wire:loading.attr="disabled" class="px-4 py-2 font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple text-sm" style="background: #047481">
                    <div wire:loading.remove wire:target="handle">
                        Process
                    </div>
                    <div wire:loading wire:target="handle">
                        Processing ...
                    </div>
                </button>
            </div>
        </form>
    @endif
</div>
