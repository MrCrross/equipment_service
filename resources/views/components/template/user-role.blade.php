<div
    @php if(!empty($clone)) { echo 'id="line-clone-UserRole"'; } @endphp
    class="flex flex-row justify-between items-end py-4 line-UserRole {{empty($clone) ? '' : 'hidden'}}"
>
    <div>
        <x-input-label
            for="role_id"
            :value="__('roles.headers.single')"
        />
        <x-select
            id="role_id"
            name="roles[]"
            class="mt-1 block w-full"
            :data="$roles"
            :selected="!empty($fieldID) ? $fieldID : 0"
            required
        />
    </div>

    <div class="flex flex-row justify-end items-end">
        <x-btn
            body="success"
            type="button"
            class="add-line-UserRole {{empty($type) ? '' : 'hidden'}}"
        >
            {{ __('+') }}
        </x-btn>
        <x-btn
            body="danger"
            type="button"
            class="remove-line-UserRole {{!empty($type) ? '' : 'hidden'}}"
        >
            {{ __('-') }}
        </x-btn>
    </div>
</div>
