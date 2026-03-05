<?php

namespace App\Models;

class FruitPurchaseVariant extends BaseModel
{
    protected $restrictRelations = [
        'procurements' => 'purchase_variant_id',
        'fruit_purchase_prices' => 'purchase_variant_id'
    ];

    public function __construct()
    {
        $fieldsConfig = require __DIR__ . '/../config/FruitPurchaseVariantFields.php';
        parent::__construct('fruit_purchase_variants', $fieldsConfig);
    }

    public function getByFruitType($fruitTypeId)
    {
        $stmt = $this->db->prepare("
            SELECT *
            FROM fruit_purchase_variants
            WHERE fruit_type_id = :fruit_type_id
            ORDER BY name
        ");

        $stmt->execute([
            'fruit_type_id' => $fruitTypeId
        ]);

        return $stmt->fetchAll();
    }
}