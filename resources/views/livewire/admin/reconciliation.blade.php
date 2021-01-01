<div wire:init="initialize">
    <span wire:loading wire:target="initialize">Loading ...</span>

    <div class="grid grid-cols-2 gap-4" x-data="{selectedPredicate:null}">
        <div>
            @if($this->isInitialized)
                @foreach($this->shapeObjectPredicates as $objectPredicate)
                    @if($this->partialMatchColumnValues->where('predicate',$objectPredicate->uri)->isEmpty())
                        @continue
                    @endif
                    <div class="mb-8">
                        <h2 class="font-bold text-lg capitalize">{{ $objectPredicate->name }}</h2>
                        <p class="text-gray-400">
                            {{ $objectPredicate->description }}
                        </p>
                        <table class="table-fixed border-collapse w-full mt-2">
                            <thead>
                            <tr>
                                <th class="w-1/3 p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell">Value</th>
                                <th class="w/2/3 p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell">Term</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($this->partialMatchColumnValues->where('predicate',$objectPredicate->uri) as $partialMatchObject)
                                <tr  class="bg-white lg:hover:bg-gray-100 flex lg:table-row flex-row lg:flex-row flex-wrap lg:flex-no-wrap mb-10 lg:mb-0">
                                    <td  class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b block lg:table-cell relative lg:static">
                                        {{ $partialMatchObject->column_value }}
                                    </td>
                                    <td class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b block lg:table-cell relative lg:static">
                                        <x-form.select name="mappings.{{ base64_encode($partialMatchObject->predicate) }}.{{ base64_encode($partialMatchObject->column_value) }}" :items="$this->search($partialMatchObject->column_value,$objectPredicate)" key="uri" value="label" required x-on:change="$dispatch('show-resource',$event.target.value)" />
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @endforeach
            @endif
        </div>
        <div class="relative">

        </div>

    </div>
    <div x-ref="resourceViewer" class="bg-indigo-200 p-4 w-md" style="position: absolute;bottom:50px;" x-data x-on:show-resource.window="
            if(!$event.detail)
            {
                $refs.resourceViewer.innerHTML='';
            }
            fetch($event.detail)
                .then(response => response.text())
                .then(html => { $refs.resourceViewer.innerHTML = html })
">

    </div>

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
