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
        .mt-2 { margin-top: 0.5rem; }
    </style>
</head>
<body>
<div class="container">
    <div class="header">{{__('completed_repair.dear')}} {{ $order->client->name }}</div>
    <p>{{__('completed_repair.header')}}</p>
    <div class="panel">
        <p>
            <span>{{__('completed_repair.order_number')}} {{$order->id}}</span>
        </p>
        <p class="mt-2">
            <span class="font-bold">{{__('equipment.headers.main.single')}}:</span> <span>{{ $order->equipment->model->type->name . ' ' . $order->equipment->model->brand->name . ' ' . $order->equipment->model->name . ' ' . $order->equipment->serial }}</span>
        </p>
    </div>
    </div>
    <p>{{__('completed_repair.take')}}</p>
    <div class="footer">
        {{__('completed_repair.respect')}} {{ config('app.name') }}
    </div>
</div>
</body>
</html>
