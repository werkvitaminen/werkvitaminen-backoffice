<?php
namespace App\Models;

class Driver extends BaseModel
{
    public function __construct()
    {
        $fieldsConfig = require __DIR__ . '/../config/DriverFields.php';
        parent::__construct('drivers', $fieldsConfig);
    }
}