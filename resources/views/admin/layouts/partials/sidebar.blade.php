<x-admin.layouts.sidebar>
    <x-admin.layouts.sidebar-link title="Dashboard"  href="{{ route('admin.dashboard') }}" :active="Request::is('admin/dashboard*')">
        <x-slot name="icon">
            <x-icons.ri-dashboard-3-line class="w-5 h-5"/>
        </x-slot>
    </x-admin.layouts.sidebar-link>

    @if(!(locale()->organization instanceof \AliSyria\LDOG\Contracts\OrganizationManager\DataSourceOrganizationContract))
        <x-admin.layouts.sidebar-link title="Departments"  href="{{ route('admin.departments.index') }}" :active="Request::is('admin/departments*')">
            <x-slot name="icon">
                <x-icons.css-tikcode class="w-4 h-4"/>
            </x-slot>
        </x-admin.layouts.sidebar-link>
    @endif

    @if(locale()->organization instanceof \AliSyria\LDOG\OrganizationManager\Cabinet)
    <x-admin.layouts.sidebar-link title="Ministries & Agencies"  href="{{ route('admin.cabinetOrganizations.index') }}" :active="Request::is('admin/cabinet-organizations*')">
        <x-slot name="icon">
            <x-icons.heroicon-o-office-building class="w-4 h-4" viewBox="0 0 20 20"/>
        </x-slot>
    </x-admin.layouts.sidebar-link>
    @endif


    @if(locale()->organization instanceof \AliSyria\LDOG\OrganizationManager\Ministry)
        <x-admin.layouts.sidebar-link title="Instituations"  href="{{ route('admin.instituations.index') }}" :active="Request::is('admin/instituations*')">
            <x-slot name="icon">
                <x-icons.heroicon-o-office-building class="w-4 h-4" viewBox="0 0 20 20"/>
            </x-slot>
        </x-admin.layouts.sidebar-link>
    @endif

    @if(locale()->organization instanceof \AliSyria\LDOG\OrganizationManager\Institution || locale()->organization instanceof \AliSyria\LDOG\OrganizationManager\IndependentAgency)
    <x-admin.layouts.sidebar-link title="Branches"  href="{{ route('admin.branches.index') }}" :active="Request::is('admin/branches*')">
        <x-slot name="icon">
            <x-icons.heroicon-o-office-building class="w-4 h-4"/>
        </x-slot>
    </x-admin.layouts.sidebar-link>
    @endif


    <x-admin.layouts.sidebar-link-collection title="Modeling" :active="Request::is('modeling*')">
        <x-slot name="icon">
            <x-icons.heroicon-o-share class="w-4 h-4"/>
        </x-slot>

        <x-admin.layouts.sidebar-link-collection-item title="Ontologies"
             href="" :active="Request::is('modeling/ontologies*')"/>
        <x-admin.layouts.sidebar-link-collection-item title="Data Templates"
             href="" :active="Request::is('modeling/data-templates*')"/>

    </x-admin.layouts.sidebar-link-collection>

    <x-admin.layouts.sidebar-link-collection title="Batch Imports" :active="Request::is('batch-imports*')">
        <x-slot name="icon">
            <x-icons.go-database-16 class="w-4 h-4"/>
        </x-slot>

        <x-admin.layouts.sidebar-link-collection-item title="Data Collections"
                                                      href="" :active="Request::is('batch-imports/data-collections*')"/>
        <x-admin.layouts.sidebar-link-collection-item title="Data Reports"
                                                      href="" :active="Request::is('batch-imports/data-reports*')"/>
    </x-admin.layouts.sidebar-link-collection>
{{--    <x-admin.layouts.sidebar-link-collection :title="__j('Charities')" :active="false">--}}
{{--        <x-slot name="icon">--}}
{{--            <x-icons.heroicon-s-office-building class="w-4 h-4" viewBox="0 0 20 20"/>--}}
{{--        </x-slot>--}}
{{--    </x-admin.layouts.sidebar-link-collection>--}}

{{--    <x-admin.layouts.sidebar-link-collection :title="__j('Donations')" :active="false">--}}
{{--        <x-slot name="icon">--}}
{{--            <x-icons.bxs-donate-blood class="w-4 h-4" viewBox="0 0 20 20"/>--}}
{{--        </x-slot>--}}
{{--    </x-admin.layouts.sidebar-link-collection>--}}

{{--    <x-admin.layouts.sidebar-link-collection :title="__j('Reports')" :active="false">--}}
{{--        <x-slot name="icon">--}}
{{--            <x-icons.bxs-report class="w-4 h-4" viewBox="0 0 20 20"/>--}}
{{--        </x-slot>--}}
{{--    </x-admin.layouts.sidebar-link-collection>--}}

{{--    <x-admin.layouts.sidebar-link-collection :title="__j(' Notifications ')" :active="Request::is('notifications*')">--}}
{{--        <x-slot name="icon">--}}
{{--            <x-icons.zondicon-notifications class="w-4 h-4" viewBox="0 0 20 20"/>--}}
{{--        </x-slot>--}}

{{--        <x-admin.layouts.sidebar-link-collection-item :title="__j('General Notifications')"--}}
{{--                                                      href="{{ route('admin.notifications.index') }}" :active="Request::is('notifications/general*')"/>--}}
{{--    </x-admin.layouts.sidebar-link-collection>--}}

{{--    <x-admin.layouts.sidebar-link-collection :title="__j('Settings')" :active="Request::is('settings*')">--}}
{{--        <x-slot name="icon">--}}
{{--            <x-icons.bxs-select-multiple class="w-4 h-4" viewBox="0 0 20 20"/>--}}
{{--        </x-slot>--}}

{{--        <x-admin.layouts.sidebar-link-collection-item :title="__j('Splash Screens')"--}}
{{--                                                      href="{{ route('admin.settings.splashScreens') }}" :active="Request::is('settings/splash-screens*')"/>--}}
{{--        <x-admin.layouts.sidebar-link-collection-item :title="__j('Countries')"--}}
{{--                                                      href="{{ route('admin.countries.index') }}" :active="Request::is('settings/countries*')"/>--}}
{{--        <x-admin.layouts.sidebar-link-collection-item :title="__j('Localization')"--}}
{{--                                                      href="{{ route('admin.translations.index') }}" :active="Request::is('settings/translations*')"/>--}}
{{--        <x-admin.layouts.sidebar-link-collection-item :title="__j('Others')"--}}
{{--                                                      href="{{ route('admin.settings.others') }}" :active="Request::is('settings/others*')"/>--}}
{{--    </x-admin.layouts.sidebar-link-collection>--}}

</x-admin.layouts.sidebar>

