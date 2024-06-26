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
                style="color: #333333; font-size:20px; font-weight: bold; line-height: 30px; -webkit-text-size-adjust:none; display: block;">{{__('order_mails.approval.header')}}</span>
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
        <td>
            <span
                style="color: #333333; font-weight: bold; line-height: 30px; -webkit-text-size-adjust:none; display: block;">
                {{__('orders.fields.description')}}:
            </span>
        </td>
        <td>
            <span
                style="color: #333333; line-height: 30px; -webkit-text-size-adjust:none; display: block;">
                {{ $order->description}}
            </span>
        </td>
    </tr>
    <tr>
        <td>
            <span
                style="color: #333333; font-weight: bold; line-height: 30px; -webkit-text-size-adjust:none; display: block;">
                {{__('orders.fields.price')}}:
            </span>
        </td>
        <td>
            <span
                style="color: #333333; line-height: 30px; -webkit-text-size-adjust:none; display: block;">
                {{ $order->price}}
            </span>
        </td>
    </tr>
    <tr>
        <td style="padding:5px"></td>
    </tr>
    <tr>
        <td>
            <a href="{{ config('app.url') . '/orders/' . $order->id  . '/status/signed' }}"
               style="color: #ffffff; line-height: 30px; -webkit-text-size-adjust:none; display: inline-block;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            font-size: 16px;
            border-radius: 4px;
            background-color: #38a169;
            " target="_blank">{{__('order_mails.approval.signed')}}</a>
        </td>
        <td>
            <a href="{{ config('app.url') . '/orders/' . $order->id  . '/status/canceled' }}"
               style="color: #ffffff; line-height: 30px; -webkit-text-size-adjust:none; display: inline-block;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            font-size: 16px;
            border-radius: 4px;
            background-color: #e53e3e;
            " target="_blank">{{__('order_mails.approval.canceled')}}</a>
        </td>
    </tr>
    <tr>
        <td style="padding:8px"></td>
    </tr>
    <tr>
        <td colspan="2">
            <span
                style="color: #333333; font-weight: bold; line-height: 30px; -webkit-text-size-adjust:none; display: block;">
                {{__('order_mails.approval.thanks')}}
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
