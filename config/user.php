<?php

return [
    'title' => 'Продажа новых автомобилей в Санкт-Петербурге',

    // бренды и соответствующие ми модели в удобном виде
    'models' => [
        'Lexus' => [
            'ES',
            'GX',
            'Hello'
        ],
        'Toyota' => [
            'Camry',
            'Corolla'
        ]
    ],

    // тип двигателя
    'engine_types' => [
        'gasoline',
        'diesel',
        'hybrid'
    ],

    // привод
    'main_axes' => [
        'front',
        'back'
    ],

    // минимальное и максимальное случайное количество авто для модели (используется при генерации
    // базы путём консольной комманды)
    'minCarCountForModel' => 0,
    'maxCarCountForModel' => 21
];
