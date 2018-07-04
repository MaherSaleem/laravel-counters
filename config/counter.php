<?php



return [

    'base_url' => 'counters',
    'counter' => [
        'table_name' => 'counters',
        'model' => \Maher\Counters\Models\Counter::class
    ],

    'counterable' => [
        'table_name' => 'counterables',
    ],
];