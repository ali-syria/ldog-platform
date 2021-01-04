<div wire:init="initialize">
    <span wire:loading wire:target="initialize">Loading ...</span>
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
                    <tr  class="bg-white {{ $failedPredicateUri==$predicate->uri?'bg-gray-100':'' }} lg:hover:bg-gray-100 flex lg:table-row flex-row lg:flex-row flex-wrap lg:flex-no-wrap mb-10 lg:mb-0">
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
                        <td class="w-full lg:w-auto p-3 text-gray-800 border border-b block lg:table-cell relative lg:static">
                            @php $object=$failedResourceProperties->filter(fn($value,$key)=>$key==$predicate->uri)->first(); @endphp

                            @if($predicate==AliSyria\LDOG\UriBuilder\UriBuilder::PREFIX_RDFS.'label' || $predicate=='@type')
                                @continue;
                            @endif

                            @php
                                if($failedPredicateUri==$predicate->uri)
                                {
                                    $fieldName='correctValue';
                                    $liveName='correctValue';
                                }
                                else
                                {
                                    $fieldName="resourceProperties[".base64_encode($predicate->uri)."]";
                                    $liveName="resourceProperties.".base64_encode($predicate->uri);
                                }
                            @endphp

                            @if(!$predicate->isObjectPredicate())
                                <x-form.input type="text" name="{{ $fieldName }}" live-name="{{ $liveName }}"/>
                            @else
                                <x-form.select name="{{ $fieldName }}" live-name="{{ $liveName }}" :items="$this->shapeObjectPredicateClassResources->where('predicate',$predicate->uri)->first()->resources ?? []" key="uri" value="label" required />
                            @endif

                            @if($failedPredicateUri==$predicate->uri)
                            <dd class="mt-2 block text-sm text-gray-900">
                                <ul class="border border-gray-200 rounded-md divide-y divide-gray-200">
                                    <li wire:key="0" class="pl-1 pr-2 py-1 flex items-center justify-between text-sm">
                                        <div class="ml-2">
                                            <span class="font-semibold text-sm text-gray-500 pr-2">Error Message</span>
                                            <span class="inline-flex items-center justify-center px-2 py-1 mr-2 text-xs font-bold leading-none text-red-800 bg-gray-100 rounded-full">{{ $errorMessage }}</span>
                                        </div>
                                    </li>
                                    <li class="pl-1 pr-2 py-1 flex items-center justify-between text-sm">
                                        <div class="ml-2">
                                            <span class="font-semibold text-sm text-gray-500 pr-2">Occurences</span>
                                            <span class="inline-flex items-center justify-center px-2 py-1 mr-2 text-xs font-bold leading-none text-red-100 bg-red-600 rounded-full">{{ $occurences }}</span>
                                        </div>
                                    </li>
                                    <li class="pl-1 pr-2 py-1 flex items-center justify-between text-sm">
                                        <div class="ml-2">
                                            <button type="submit" wire:click.prevent="apply" wire:loading.attr="disabled" class="px-2 py-1 font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple text-sm" style="background: #047481">
                                                <div wire:loading.remove wire:target="apply">
                                                    Apply
                                                </div>
                                                <div wire:loading wire:target="apply">
                                                    Processing ...
                                                </div>
                                            </button>
                                            @if($occurences>0)
                                            <button type="submit" wire:click.prevent="applyAll" wire:loading.attr="disabled" class="px-2 py-1 font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple text-sm" style="background: #047481">
                                                <div wire:loading.remove wire:target="applyAll">
                                                    Apply All
                                                </div>
                                                <div wire:loading wire:target="applyAll">
                                                    Processing ...
                                                </div>
                                            </button>
                                            @endif
                                        </div>
                                    </li>
                                </ul>
                            </dd>
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </form>
    @endif

    @if($hasFailedRecord===false)
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
    @endif
</div>
