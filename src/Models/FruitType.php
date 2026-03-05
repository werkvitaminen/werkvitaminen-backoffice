<?php

namespace App\Models;

class FruitType extends BaseModel
{
    protected $restrictRelations = [
        'fruit_box_type_items' => 'fruit_type_id',
        'fruit_box_adjustments' => 'fruit_type_id',
        'fruit_box_custom_items' => 'fruit_type_id'
    ];

    public function __construct()
    {
        $fieldsConfig = require __DIR__ . '/../config/FruitTypeFields.php';
        parent::__construct('fruit_types', $fieldsConfig);
    }
}