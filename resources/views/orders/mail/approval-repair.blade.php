<!DOCTYPE html>
<html>
<head>
    <style>
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            font-family: Arial, sans-serif;
            background-color: #f9fafb;
        }

        .header {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
            color: #333;
        }

        .panel {
            background-color: #fff;
            padding: 10px;
            border-radius: 4px;
            border: 1px solid #e5e7eb;
            margin-bottom: 20px;
        }

        .footer {
            margin-top: 20px;
            color: #555;
        }
        .font-bold { font-weight: 700; }
        .button {
            display: inline-block;
            padding: 10px 20px;
            margin: 10px 15px;
            text-align: center;
            text-decoration: none;
            font-size: 16px;
            border-radius: 4px;
        }
        .button-green {
            background-color: #38a169;
            color: #fff;
        }
        .button-red {
            background-color: #e53e3e;
            color: #fff;
        }
        .mt-2 { margin-top: 0.5rem; }
    </style>
    <title></title>
</head>
<body>
<div class="container">
    <div class="header">{{__('approval_repair.dear')}} {{ $order->client->name }}</div>
    <p>{{__('approval_repair.header')}}</p>
    <div class="panel">
        <p>
            <span>{{__('approval_repair.order_number')}} {{$order->id}}</span>
        </p>
        <p class="mt-2">
            <span class="font-bold">{{__('equipment.headers.main.single')}}:</span> <span>{{ $order->equipment->model->type->name . ' ' . $order->equipment->model->brand->name . ' ' . $order->equipment->model->name . ' ' . $order->equipment->serial }}</span>
        </p>
    </div>
    <div class="panel">
        <p class="font-bold">{{__('orders.fields.description')}}:</p>
        <p>{{ $order->description}}</p>
    </div>
    <div class="panel">
        <p class="font-bold">{{__('orders.fields.price')}}:</p>
        <p>{{ $order->price}}</p>
    </div>
    <div>
        <a href="{{ config('app.url') . '/orders/' . $order->id  . '/status/signed' }}" class="button button-green">{{__('approval_repair.signed')}}</a>
        <a href="{{ config('app.url') . '/orders/' . $order->id  . '/status/canceled' }}" class="button button-red">{{__('approval_repair.canceled')}}</a>
    </div>
    <p>{{__('approval_repair.thanks')}}</p>
    <div class="footer">
        {{__('approval_repair.respect')}} {{ config('app.name') }}
    </div>
</div>
</body>
</html>
