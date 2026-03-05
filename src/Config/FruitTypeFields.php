<?php

return [
    'name' => [
        'label' => 'Naam',
        'type' => 'text',
        'required' => true,
        'searchable' => true,
        'list' => true,
        'default' => ''
    ],
    'unit' => [
        'label' => 'Eenheid',
        'type' => 'text',
        'required' => true,
        'list' => true,
        'searchable' => false,
        'default' => 'stuks'
    ],
    'portion_multiplier' => [
        'label' => 'Porties per pak',
        'type' => 'number',
        'required' => true,
        'default' => 1,
        'list' => true
    ],

    'pieces_per_unit' => [
        'label' => 'Fysieke stuks per pak',
        'type' => 'number',
        'required' => true,
        'default' => 1,
        'list' => true
    ]
];

