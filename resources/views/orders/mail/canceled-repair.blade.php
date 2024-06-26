<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<body>
<table border="0" cellpadding="0" cellspacing="0" bgcolor="#ffffff"
       style="margin:0; padding:10px; font: 18px Arial, sans-serif; width: 100%; border-radius: 4px;
            border: 1px solid #e5e7eb;">
    <tr>
        <td colspan="2">
            <span
                style="color: #333333; font-size:20px; font-weight: bold; line-height: 30px; -webkit-text-size-adjust:none; display: block;">{{__('order_mails.dear')}} {{ $order->client->name }}</span>
        </td>
    </tr>
    <tr>
        <td style="padding:5px"></td>
    </tr>
    <tr>
        <td colspan="2">
            <span
                style="color: #333333; font-size:20px; font-weight: bold; line-height: 30px; -webkit-text-size-adjust:none; display: block;">{{__('order_mails.canceled.header')}}</span>
        </td>
    </tr>
    <tr>
        <td style="padding:8px"></td>
    </tr>
    <tr>
        <td colspan="2">
            <span
                style="color: #333333; font-weight: bold; line-height: 30px; -webkit-text-size-adjust:none; display: block;">
                {{__('order_mails.order_number')}}{{$order->id}}
            </span>
        </td>
    </tr>
    <tr>
        <td>
            <span
                style="color: #333333; font-weight: bold; line-height: 30px; -webkit-text-size-adjust:none; display: block;">
                {{__('equipment.headers.main.single')}}:
            </span>
        </td>
        <td>
            <span
                style="color: #333333; line-height: 30px; -webkit-text-size-adjust:none; display: block;">
                {{ $order->equipment->model->type->name . ' ' . $order->equipment->model->brand->name . ' ' . $order->equipment->model->name . ' ' . $order->equipment->serial }}
            </span>
        </td>
    </tr>
    <tr>
        <td style="padding:8px"></td>
    </tr>
    <tr>
        <td colspan="2">
            <span
                style="color: #333333; font-weight: bold; line-height: 30px; -webkit-text-size-adjust:none; display: block;">
                {{__('order_mails.canceled.wait')}}
            </span>
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <span
                style="color: #333333; font-weight: bold; line-height: 30px; -webkit-text-size-adjust:none; display: block;">
                {{__('order_mails.respect')}} {{ config('app.name') }}
            </span>
        </td>
    </tr>
</table>
</body>
</html>
