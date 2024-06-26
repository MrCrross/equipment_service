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
        'date_repair' => 'Repair completion date',
    ],
    'messages' => [
        'store' => 'The application saved successfully',
        'update' => 'Application changed successful',
        'delete' => 'The application was deleted successfully',
    ],
    'headers' => [
        'single' => 'Application',
        'title' => 'Applications',
        'view' => 'Viewing an application',
        'create' => 'Create an application',
        'update' => 'Change the application',
    ],
    'mail' => [
        'headers' => [
            'approval' => 'Do you allow repairs?',
            'completed' => 'The repair is completed',
            'canceled' => 'The application has been cancelled',
            'closed' => 'The application is closed',
            'appointment_master' => 'Appointment by the master to application',
            'changed_date' => 'Changing the repair date',
        ],
    ]
];
