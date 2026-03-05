<?php
namespace App\Models;

class CustomerLocation extends BaseModel
{
    public function __construct()
    {
        $fieldsConfig = require __DIR__ . '/../config/CustomerLocationFields.php';
        parent::__construct('customer_locations', $fieldsConfig);
    }
}