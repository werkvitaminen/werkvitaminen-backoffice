<?php
return [
    'customer_id' => ['type'=>'hidden'],
    'name' => ['label'=>'Naam locatie', 'type'=>'text', 'required'=>true, 'list'=>true],
    'street' => ['label'=>'Straat', 'type'=>'text', 'required'=>true, 'list'=>true],
    'house_number' => ['label'=>'Huisnummer', 'type'=>'text', 'required'=>true, 'list'=>true],
    'postal_code' => ['label'=>'Postcode', 'type'=>'text', 'required'=>true, 'list'=>true],
    'city' => ['label'=>'Plaats', 'type'=>'text', 'required'=>true, 'list'=>true],
    'country' => ['label'=>'Land', 'type'=>'text', 'required'=>true, 'list'=>true],
    'is_primary' => ['label'=>'Primaire locatie', 'type'=>'checkbox', 'default'=>0],
    'active' => ['label'=>'Actief', 'type'=>'checkbox', 'default'=>1],
];