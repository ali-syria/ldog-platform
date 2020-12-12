<div>
    <div class="mb-24">
        <x-components.page-header>
            <x-components.page-title>@langj('Food Categories')</x-components.page-title>
        </x-components.page-header>

        <x-components.crud-toolbox>
            <x-components.create-button>
                @langj('New Food Category')
            </x-components.create-button>
        </x-components.crud-toolbox>

        <x-components.data-table class="lg:w-4/6" sortable-entity-name="foodCategories">
            <x-slot name="head">
                <tr>
                    <x-components.data-table-th></x-components.data-table-th>
                    <x-components.data-table-th class="text-left">@langj('ID')</x-components.data-table-th>
                    <x-components.data-table-th class="text-left w-3/4">@langj('Name')</x-components.data-table-th>
                    <x-components.data-table-th>@langj('Actions')</x-components.data-table-th>
                </tr>
            </x-slot>
            <x-slot name="body">
                @foreach($this->foodCategories as $foodCategory)
                    <tr data-itemId="{{{ $foodCategory->id }}}" class="hover:bg-gray-50"  wire:key="{{ 'tr'.$loop->index }}">
                        <x-components.data-table-sortable-handle />
                        <x-components.data-table-td>
                            {{ $foodCategory->id }}
                        </x-components.data-table-td>

                        <x-components.data-table-td>
                            <x-components.attribute-langs :model="$foodCategory" attribute="name"/>
                        </x-components.data-table-td>

                        <x-components.data-table-td>
                            <div class="flex items-center space-x-4 text-sm">
                                <x-components.edit-button :id="$foodCategory->id"/>
                                <x-components.delete-button :id="$foodCategory->id"/>
                            </div>
                        </x-components.data-table-td>
                    </tr>
                @endforeach
            </x-slot>
        </x-components.data-table>
    </div>

    <x-components.modal :is-modal-open="$isModalOpen" action="store">
        <x-slot name="title">
            @if($this->isCreateOpertion())
                @langj('New Food Category')
            @else
                @langj('Update :name',[
                    'name'=>$this->foodCategory->name
                ])
            @endif
        </x-slot>
        <x-slot name="body">
            <span class="text-gray-700 font-semibold">@langj('Name')</span>
            <x-form.input-langs name="name" :model="null"/>
        </x-slot>
        <x-slot name="buttons">
            <x-components.save-button live-target="store"/>
        </x-slot>
    </x-components.modal>
</div>

