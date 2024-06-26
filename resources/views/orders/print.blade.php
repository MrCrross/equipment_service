<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Заявка на проведение сервисного обслуживания</title>
</head>
<body style="font-family: 'Dejavu Sans', sans-serif; padding: 10px;">
<div style="max-width: 960px; margin: auto; background-color: white; padding: 10px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
    <div style="text-align: center; margin-bottom: 16px;">
        <h1 style="font-weight: bold; font-size: 16px;">Заявка на проведение сервисного обслуживания № {{$order->id}}</h1>
    </div>
    <table style="width: 100%; border-collapse: collapse; margin-bottom: 16px; border: 1px solid black;">
        <tr style="border: 1px solid black;">
            <td style="border: 1px solid black; font-size: 14px; padding: 4px;">Название компании:</td>
            <td style="padding: 4px;">{{config('app.name')}}</td>
        </tr>
        <tr style="border: 1px solid black;">
            <td style="width:40%; font-size: 14px; border: 1px solid black; padding: 4px;">Мастер:</td>
            <td style="padding: 4px; border: 1px solid black;">{{$order->master->name}}</td>
        </tr>
        <tr>
            <td style="width:40%; font-size: 14px; border: 1px solid black;  padding: 4px;">E-mail:</td>
            <td style="padding: 4px; border: 1px solid black;">{{$order->master->email}}</td>
        </tr>
    </table>
    <table style="width: 100%; border-collapse: collapse; margin-bottom: 16px; border: 1px solid black;">
        <tr style="border: 1px solid black;">
            <td style="width:40%; font-size: 14px;border: 1px solid black; padding: 4px;">Клиент:</td>
            <td style="padding: 4px;border: 1px solid black;">{{$order->client->name}}</td>
        </tr>
        <tr>
            <td style="width:40%; font-size: 14px;border: 1px solid black; padding: 4px;">E-mail:</td>
            <td style="padding: 4px;border: 1px solid black;">{{$order->client->email}}</td>
        </tr>
        <tr>
            <td style="width:40%; font-size: 14px;border: 1px solid black; padding: 4px;">Номер телефона:</td>
            <td style="padding: 4px;border: 1px solid black;">{{$order->client->phone}}</td>
        </tr>
    </table>
    <table style="width: 100%; border-collapse: collapse; margin-bottom: 16px; border: 1px solid black;">
        <tr style="border: 1px solid black;">
            <td style="width:40%; font-size: 14px;border: 1px solid black; padding: 4px;">Тип оборудования:</td>
            <td style="padding: 4px;border: 1px solid black;">{{ $order->equipment->model->type->name }}</td>
        </tr>
        <tr style="border: 1px solid black;">
            <td style="width:40%; font-size: 14px;border: 1px solid black; padding: 4px;">Модель:</td>
            <td style="padding: 4px;border: 1px solid black;">{{ $order->equipment->model->brand->name . ' ' . $order->equipment->model->name}}</td>
        </tr>
        <tr style="border: 1px solid black;">
            <td style="font-size: 14px;border: 1px solid black; padding: 4px;">Серийный номер:</td>
            <td style="padding: 4px;border: 1px solid black;">{{$order->equipment->serial}}</td>
        </tr>
        <tr>
            <td style="font-size: 14px;border: 1px solid black; padding: 4px;">Кодовый номер:</td>
            <td style="padding: 4px;border: 1px solid black;"></td>
        </tr>
    </table>
    <div style="margin-bottom: 16px;">
        <p style="font-size: 14px;">Подробное описание проблемы:</p>
        <div style="border: 1px solid #cbd5e0; min-height: 128px; padding: 8px;">
            {{$order->description}}
        </div>
    </div>
    <table>
        <tr>
            <td>
                <span style="font-size: 14px; color: #4a5568;">Дата:</span>
                <span style="border: 1px solid #cbd5e0; padding: 10px 20px; text-align: center;">{{\Carbon\Carbon::now()->format('d.m.Y H:i')}}</span>
            </td>
            <td style="padding-left: 10px;">
                <span style="font-size: 14px; color: #4a5568;">Подпись:</span>
                <span style="border: 1px solid #cbd5e0; padding: 10px 20px; color:#ffffff; ">{{\Carbon\Carbon::now()->format('d.m.Y H:i')}}</span>
            </td>
        </tr>
    </table>
</div>
</body>
</html>
