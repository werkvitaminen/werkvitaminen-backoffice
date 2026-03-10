<?php

namespace App\Models;
use App\Core\Database;


class FruitBoxTypeItem extends BaseModel
{
    protected $restrictRelations = [];

    public function __construct()
    {
        $fieldsConfig = require __DIR__ . '/../Config/FruitBoxTypeItemFields.php';
        parent::__construct('fruit_box_type_items', $fieldsConfig);
    }

    public function getByBoxType($boxTypeId)
    {
   
        $db = Database::getInstance();

        $stmt = $db->prepare("
            SELECT i.*, f.name AS fruit_name
            FROM fruit_box_type_items i
            JOIN fruit_types f ON f.id = i.fruit_type_id
            WHERE i.box_type_id = :box_type_id
            ORDER BY f.name
        ");

        $stmt->execute([
            'box_type_id' => $boxTypeId
        ]);

        return $stmt->fetchAll();
      
    }
}