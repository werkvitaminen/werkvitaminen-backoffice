<?php

return [

    'box_type_id' => [
        'type' => 'hidden'
    ],

    'fruit_type_id' => [
        'label' => 'Fruitsoort',
        'type' => 'select',
        'required' => true,
        'list' => true
    ],

    'type' => [
        'label' => 'Type',
        'type' => 'select',
        'options' => [
            'ratio' => 'Ratio',
            'per_x' => 'Vast aantal'
        ],
        'required' => true
    ],

    'ratio_value' => [
        'label' => 'Ratio',
        'type' => 'number',
        'required' => false,
        'list' => true,
        'default' => '',
    ],

    'per_x_pieces' => [
        'label' => 'Per X box stuks',
        'type' => 'number',
        'required' => false,
        'list' => true,
        'default' => '',
    ],

    'quantity' => [
        'label' => 'Aantal',
        'type' => 'number',
        'required' => false,
        'list' => true,
        'default' => '',
    ]

];