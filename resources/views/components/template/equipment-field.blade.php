<div
    @php if(!empty($clone)) { echo 'id="line-clone-EquipmentField"'; } @endphp
    class="flex flex-row justify-between items-end gap-2 py-4 line-EquipmentField {{empty($clone) ? '' : 'hidden'}}"
>
    <div>
        <x-input-label
            for="field_id"
            :value="__('equipment.fields.fields.name')"
        />
        <x-select
            id="field_id"
            name="fields[{{$key}}][id]"
            class="mt-1 block w-full select-EquipmentField"
            :data="$fields"
            :selected="!empty($fieldID) ? $fieldID : 0"
            :additionalFields="['code']"
            data-value="{{ !empty($fieldValue) ? $fieldValue : '' }}"
            data-key="{{$key}}"
        />
    </div>
    <div>
        <x-input-label
            for="field_id"
            class="hidden labelValue-EquipmentField"
            :value="__('equipment.fields.fields.value')"
        />
        <div class="inputContainer-EquipmentField"></div>
    </div>

    <div class="flex flex-row justify-end items-end">
        <x-btn
            body="success"
            type="button"
            class="add-line-EquipmentField {{empty($type) ? '' : 'hidden'}}"
        >
            {{ __('+') }}
        </x-btn>
        <x-btn
            body="danger"
            type="button"
            class="remove-line-EquipmentField {{!empty($type) ? '' : 'hidden'}}"
        >
            {{ __('-') }}
        </x-btn>
    </div>
</div>
