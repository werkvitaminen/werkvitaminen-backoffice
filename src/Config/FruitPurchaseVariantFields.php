<?php

return [

    'fruit_type_id' => [
        'type' => 'hidden'
    ],

    'name' => [
        'label' => 'Variant / maat',
        'type' => 'text',
        'required' => true,
        'list' => true
    ],

    'pieces_per_colli' => [
        'label' => 'Stuks per colli',
        'type' => 'number',
        'required' => true,
        'list' => true
    ],

    'colli_weight_kg' => [
        'label' => 'Gewicht (kg)',
        'type' => 'number'
    ],

    'default_variant' => [
        'label' => 'Standaard',
        'type' => 'checkbox'
    ]

];