<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Navigation Links -->
                <div class="space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    @can('equipment_view')
                        <x-nav-link :href="route('equipment.main.index')" :active="request()->routeIs('equipment.main.*')">
                            {{ __('equipment.headers.main.title') }}
                        </x-nav-link>
                    @endcan
                    @can('equipment_models_view')
                        <x-nav-link :href="route('equipment.models.index')" :active="request()->routeIs('equipment.models.*')">
                            {{ __('equipment.headers.models.title') }}
                        </x-nav-link>
                    @endcan
                    @can('equipment_brands_view')
                        <x-nav-link :href="route('equipment.brands.index')" :active="request()->routeIs('equipment.brands.*')">
                            {{ __('equipment.headers.brands.title') }}
                        </x-nav-link>
                    @endcan
                    @can('equipment_types_view')
                        <x-nav-link :href="route('equipment.types.index')" :active="request()->routeIs('equipment.types.*')">
                            {{ __('equipment.headers.types.title') }}
                        </x-nav-link>
                    @endcan
                    @can('equipment_fields_view')
                        <x-nav-link :href="route('equipment.fields.index')" :active="request()->routeIs('equipment.fields.*')">
                            {{ __('equipment.headers.fields.title') }}
                        </x-nav-link>
                    @endcan
                </div>
            </div>
        </div>
    </div>
</nav>
