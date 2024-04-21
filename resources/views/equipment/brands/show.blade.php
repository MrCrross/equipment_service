<x-app-layout>
    <x-slot name="header">
        <div class="mb-5">
            <div class="float-left">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight ">{{ __('equipment.headers.brands.view') }}</h2>
            </div>
            <div class="float-right">
                <x-a href="{{ route('equipment.brands.index') }}">{{ __('actions.back') }}</x-a>
            </div>
        </div>
    </x-slot>
    <div class="container mx-auto my-5 bg-gray-50 rounded flex flex-row justify-center items-center">
        @if ($message = Session::get('success'))
            <div class="w-full px-10 py-5 bg-green-500">
                <p>{{ $message }}</p>
            </div>
        @endif
        <div class="py-5 mx-5">
            <div class="flex flex-col">
                <strong>{{ __('equipment.fields.brands.name') }}</strong>
                {{ $brand->name }}
            </div>
            <div class="flex flex-col">
                <strong>{{ __('equipment.fields.brands.creator') }}</strong>
                {{ $brand->creator->name }}
            </div>
            @if(!empty($brand->deleted_at))
                @canany(['equipment_brands_view-delete', 'equipment_brands_edit'])
                    <div class="my-3">
                        <form method="POST" action="{{route('equipment.brands.recovery', $brand->id)}}">
                            @csrf
                            @method('PATCH')
                            <x-primary-button>{{ __('actions.recovery') }}</x-primary-button>
                        </form>
                    </div>
                @endcanany
            @endif
        </div>
    </div>
</x-app-layout>
