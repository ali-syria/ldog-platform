<div>
    <div class="mb-24">
        <x-components.page-header>
            <x-components.page-title>Ministries & Independent Agencies</x-components.page-title>
        </x-components.page-header>

        <x-components.crud-toolbox>
            <x-components.create-button>
                New Cabinet Organization
            </x-components.create-button>
        </x-components.crud-toolbox>

        <x-components.data-table class="lg:w-full">
            <x-slot name="head">
                <tr>
                    <x-components.data-table-th class="text-left w-1/6">Logo</x-components.data-table-th>
                    <x-components.data-table-th class="text-left">Name</x-components.data-table-th>
                    <x-components.data-table-th class="text-left">Type</x-components.data-table-th>
                    <x-components.data-table-th class="text-left">Description</x-components.data-table-th>
                    <x-components.data-table-th class="text-left">Employee Name</x-components.data-table-th>
                    <x-components.data-table-th class="text-left">Employee Username</x-components.data-table-th>
                </tr>
            </x-slot>
            <x-slot name="body">
                @foreach($this->organizations as $organization)
                    <tr data-itemId="{{{ $organization->getUri() }}}" class="hover:bg-gray-50"  wire:key="{{ 'tr'.$loop->index }}">
                        <x-components.data-table-td>
                            <img src="{{ $organization->getLogoUrl() }}">
                        </x-components.data-table-td>

                        <x-components.data-table-td>
                            <a href="{{ $organization->getUri() }}" target="_blank" class="text-purple-500 hover:text-indigo-900">{{ $organization->getName() }}</a>
                        </x-components.data-table-td>

                        <x-components.data-table-td>
                            @if($organization instanceof \AliSyria\LDOG\OrganizationManager\Ministry)
                                <span class="text-gray-500">{{ \App\Enums\CabinetOrganizationType::getDescription(\App\Enums\CabinetOrganizationType::MINISTRY) }}</span>
                            @elseif($organization instanceof \AliSyria\LDOG\OrganizationManager\IndependentAgency)
                                <span class="text-gray-500">{{ \App\Enums\CabinetOrganizationType::getDescription(\App\Enums\CabinetOrganizationType::INDEPENDENT_AGENCY) }}</span>
                            @else

                            @endif
                        </x-components.data-table-td>

                        <x-components.data-table-td>
                            {{ $organization->getDescription() }}
                        </x-components.data-table-td>
                        @php
                            $employee=\AliSyria\LDOG\OrganizationManager\Employee::retrieveByOrganization($organization->getUri());
                        @endphp
                        <x-components.data-table-td>
                            @if($employee)
                                <a href="{{ $employee->getUri() }}" target="_blank" class="text-purple-500 hover:text-indigo-900">{{ $employee->getName() }}</a>
                            @endif
                        </x-components.data-table-td>

                        <x-components.data-table-td>
                            @if($employee)
                                {{ $employee->getLoginAccount()->username }}
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
                New Cabinet Organization
            @else

            @endif
        </x-slot>
        <x-slot name="body">
            <h6 class="pb-2 mb-2 border-b-2 border-blue-500 border-opacity-50 font-bold">Organization</h6>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 xl:grid-cols-2 gap-4">
                <div class="form-group">
                    <span class="text-gray-700 text-xs font-semibold">Name</span>
                    <x-form.input type="text" name="name" required/>
                </div>
                <div class="form-group">
                    <span class="text-gray-700 text-xs font-semibold">Type</span>
                    <x-form.select name="type" :items="$this->cabinetOrganizationTypes" required/>
                </div>
                <div class="form-group">
                    <span class="text-gray-700 text-xs font-semibold">Description</span>
                    <x-form.input type="textarea" name="description" required/>
                </div>
                <div class="form-group">
                    <span class="text-gray-700 text-xs font-semibold">Logo</span>
                    <x-form.img live-name="logo" :temporary-url="optional($logo)->temporaryUrl() ?? $logo" required/>
                </div>
            </div>
            <h6 class="pb-2 mb-2 border-b-2 border-blue-500 border-opacity-50 font-bold">Employee</h6>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 xl:grid-cols-2 gap-4">
                <div class="form-group">
                    <span class="text-gray-700 text-xs font-semibold">Identifier</span>
                    <x-form.input type="text" name="employeeId" required/>
                </div>
                <div class="form-group">
                    <span class="text-gray-700 text-xs font-semibold">Name</span>
                    <x-form.input type="text" name="employeeName" required/>
                </div>
                <div class="form-group">
                    <span class="text-gray-700 text-xs font-semibold">Description</span>
                    <x-form.input type="textarea" name="employeeDescription" required/>
                </div>
                <div class="form-group">
                    <span class="text-gray-700 text-xs font-semibold">Username</span>
                    <x-form.input type="text" name="employeeUsername" required/>
                </div>
                <div class="form-group">
                    <span class="text-gray-700 text-xs font-semibold">Password</span>
                    <x-form.input type="text" name="employeePassword" required/>
                </div>
            </div>
        </x-slot>
        <x-slot name="buttons">
            <x-components.save-button live-target="store"/>
        </x-slot>
    </x-components.modal>
</div>


