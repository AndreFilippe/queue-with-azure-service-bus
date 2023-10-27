<?php

return [
    'url' => env('SERVICE_BUS_URL'),
    'key' => env('SERVICE_BUS_KEY'),
    'police' => env('SERVICE_BUS_POLICE'),

    'queues' => [
        'default' => env('SERVICE_BUS_QUEUE_DEFAULT', 'default'),
    ]
];
