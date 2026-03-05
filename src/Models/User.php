<?php
namespace App\Models;

class User extends BaseModel
{
    public function __construct()
    {
        $fieldsConfig = require __DIR__ . '/../config/UserFields.php';
        parent::__construct('users', $fieldsConfig);
    }
}