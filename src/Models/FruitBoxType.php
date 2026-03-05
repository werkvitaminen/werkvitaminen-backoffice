<?php

namespace App\Models;

class FruitBoxType extends BaseModel
{
    protected $restrictRelations = [
        'fruit_box_type_items' => 'box_type_id',
        'fruit_boxes' => 'box_type_id'
    ];

    public function __construct()
    {
        $fieldsConfig = require __DIR__ . '/../Config/FruitBoxTypeFields.php';
        parent::__construct('fruit_box_types', $fieldsConfig);
    }
}