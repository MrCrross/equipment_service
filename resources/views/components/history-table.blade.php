<h2 class="font-semibold text-2xl text-gray-800 leading-tight ">{{__('history.fields.title')}}</h2>
<table class="table-auto w-full m-5">
    <thead>
    <tr>
        <th class="w-1/8 border-2 border-gray-400 px-4 py-2">№</th>
        <th class="w-2/8 border-2 border-gray-400 px-4 py-2">{{ __('history.fields.action') }}</th>
        <th class="w-1/8 border-2 border-gray-400 px-4 py-2">{{ __('history.fields.initiator') }}</th>
        <th class="w-1/8 border-2 border-gray-400 px-4 py-2">{{ __('history.fields.performed') }}</th>
        <th class="w-3/8 border-2 border-gray-400 px-4 py-2">{{ __('history.fields.message') }}</th>
    </tr>
    </thead>
    <tbody>
    @if(!empty($history))
        @foreach ($history as $key => $row)
            <tr>
                <td class="border-2 border-gray-400 px-4 py-2">{{ ++$key }}</td>
                <td class="border-2 border-gray-400 px-4 py-2">{{ $row['message'] }}</td>
                <td class="border-2 border-gray-400 px-4 py-2">{{ $row['user']->name }}</td>
                <td class="border-2 border-gray-400 px-4 py-2">{{ $row['performed'] }}</td>
                <td class="border-2 border-gray-400 px-4 py-2">
                    @if(!empty($row['messages']))
                        @foreach($row['messages'] as $message)
                            <p>{{$message}}</p>
                        @endforeach
                    @endif
                </td>
            </tr>
        @endforeach
    @else
        <tr>
            <td colspan="5">
                <x-no-data></x-no-data>
            </td>
        </tr>
    @endif
    </tbody>
</table>
