<?php
namespace App\Models;

class Customer extends BaseModel
{
    protected $restrictRelations = [
        'customer_locations' => 'customer_id'
    ];

    public function __construct()
    {
        $fieldsConfig = require __DIR__ . '/../config/CustomerFields.php';
        parent::__construct('customers', $fieldsConfig);
    }
}