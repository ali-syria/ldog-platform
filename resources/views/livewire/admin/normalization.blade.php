<div class="overflow-auto h-screen" style="max-width: 1200px">
    <table class="table-fixed border-collapse">
        <thead>
        <tr>
            @foreach($this->predicates as $predicate)
                <th x-data="{ tooltip: false }" x-on:mouseover="tooltip = true" x-on:mouseleave="tooltip = false" class="w-32 p-3 font-bold  bg-gray-200 text-gray-600 border border-gray-300  lg:table-cell">
                    <div class="relative" x-cloak x-show.transition.origin.top="tooltip">
                        <div class="absolute top-20 z-10 w-32 p-2 -mt-1 text-sm leading-tight text-white transform  -translate-y-full bg-orange-500 rounded-lg shadow-lg">
                            {{ $predicate->description }}
                        </div>
                    </div>
                    {{ $predicate->name }}
                </th>
            @endforeach
        </tr>
        </thead>
        <tbody>
        @foreach($this->resourceNodes as $node)
            <tr  class="bg-white lg:hover:bg-gray-100 flex lg:table-row flex-row lg:flex-row flex-wrap lg:flex-no-wrap mb-10 lg:mb-0">
                @foreach(collect($node->getProperties())->sortBy(function($property,$key){
            return optional($this->predicates->where('uri',$key)->first())->order;
}) as $predicate=>$object)
                    @if(!($object instanceof ML\JsonLD\TypedValue) || $predicate==AliSyria\LDOG\UriBuilder\UriBuilder::PREFIX_RDFS.'label')
                        @continue;
                    @endif
                    <td class="lg:w-auto p-3 text-gray-800 text-center border border-b block lg:table-cell relative lg:static">
                        {{ $object->getValue() }}
                    </td>
                @endforeach
            </tr>
        @endforeach
        </tbody>
    </table>
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
