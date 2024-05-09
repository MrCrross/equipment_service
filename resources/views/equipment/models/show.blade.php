<x-app-layout>
    <x-slot name="header">
        <div class="mb-5">
            <div class="float-left">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight ">{{ __('equipment.headers.models.view') }}</h2>
            </div>
            <div class="float-right">
                <x-a href="{{ route('equipment.models.index') }}">{{ __('actions.back') }}</x-a>
            </div>
        </div>
    </x-slot>
    <div class="container mx-auto my-5 bg-gray-50 rounded flex flex-col justify-center items-center">
        @if ($message = Session::get('success'))
            <div class="w-full px-10 py-5 bg-green-500">
                <p>{{ $message }}</p>
            </div>
        @endif
        <div class="py-5 mx-5">
            <div class="flex flex-col">
                <strong>{{ __('equipment.fields.models.name') }}</strong>
                {{ $model->name }}
            </div>
            <div class="flex flex-col">
                <strong>{{ __('equipment.headers.types.single') }}</strong>
                {{ $model->type->name }}
            </div>
            <div class="flex flex-col">
                <strong>{{ __('equipment.headers.brands.single') }}</strong>
                {{ $model->brand->name }}
            </div>
            <div class="flex flex-col">
                <strong>{{ __('equipment.fields.models.creator') }}</strong>
                {{ $model->creator->name }}
            </div>
            @if(!empty($model->deleted_at))
                @canany(['equipment_models_view-delete', 'equipment_models_edit'])
                    <div class="my-3">
                        <form method="POST" action="{{route('equipment.models.recovery', $model->id)}}">
                            @csrf
                            @method('PATCH')
                            <x-primary-button>{{ __('actions.recovery') }}</x-primary-button>
                        </form>
                    </div>
                @endcanany
            @endif
        </div>
        <x-history-table :history="$history"></x-history-table>
    </div>
</x-app-layout>
