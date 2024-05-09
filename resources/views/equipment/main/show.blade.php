<x-app-layout>
    <x-slot name="header">
        <div class="mb-5">
            <div class="float-left">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight ">{{ __('equipment.headers.main.view') }}</h2>
            </div>
            <div class="float-right">
                <x-a href="{{ route('equipment.main.index') }}">{{ __('actions.back') }}</x-a>
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
                <strong>{{ __('equipment.headers.models.single') }}</strong>
                {{ $equipment->model->type->name . ' ' . $equipment->model->brand->name . ' ' . $equipment->model->name }}
            </div>
            <div class="flex flex-col">
                <strong>{{ __('equipment.fields.main.short_name') }}</strong>
                {{ $equipment->short_name }}
            </div>
            <div class="flex flex-col">
                <strong>{{ __('equipment.fields.main.serial') }}</strong>
                {{ $equipment->serial }}
            </div>
            @if(!empty($equipment->fields))
                @foreach($equipment->fields as $field)
                    <div class="flex flex-col">
                        <strong>{{ $field->field->name }}</strong>
                        {{ $field->value }}
                    </div>
                @endforeach
            @endif
            <div class="flex flex-col">
                <strong>{{ __('equipment.fields.main.creator') }}</strong>
                {{ $equipment->creator->name }}
            </div>
            <div class="flex flex-col">
                <strong>{{ __('equipment.fields.main.editor') }}</strong>
                @if(empty($equipment->editor))
                    <x-no-data font="1"></x-no-data>
                @else
                    {{ $equipment->editor->name }}
                @endif
            </div>
            <div class="flex flex-col">
                <strong>{{ __('equipment.fields.main.status') }}</strong>
                @if(empty($equipment->deleted_at))
                    <x-badge body="green">{{ __('equipment.statuses.success') }}</x-badge>
                @else
                    <x-badge body="red">{{ __('equipment.statuses.delete') }}</x-badge>
                @endif
            </div>
            @if(!empty($equipment->deleted_at))
                @canany(['equipment_view-delete', 'equipment_edit'])
                    <div class="my-3">
                        <form method="POST" action="{{route('equipment.main.recovery', $equipment->id)}}">
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
