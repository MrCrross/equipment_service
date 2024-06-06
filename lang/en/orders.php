<?php

return [
    'fields' => [
        'master' => 'Master',
        'client' => 'Client',
        'status' => 'Status',
        'phone' => 'Phone client',
        'description' => 'Description',
        'creator' => 'Creator',
        'editor' => 'Editor',
        'price' => 'Cost (rubles)',
    ],
    'messages' => [
        'store' => 'The order saved successfully',
        'update' => 'Order changed successful',
        'delete' => 'The order was deleted successfully',
    ],
    'headers' => [
        'single' => 'Order',
        'title' => 'Orders',
        'view' => 'Viewing a order',
        'create' => 'Create a order',
        'update' => 'Change the order',
    ],
    'mail' => [
        'headers' => [
            'approval' => 'Do you allow repairs?',
            'completed' => 'The repair is completed',
            'canceled' => 'The application has been cancelled',
            'closed' => 'The application is closed',
        ],
    ]
];
