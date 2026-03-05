<?php
namespace App\Controllers;

abstract class BaseController
{
    protected function render($view, $data = [])
    {
        extract($data);
        include __DIR__ . "/../Views/$view.php";
    }

    protected function validateRequired(array $data, array $fields)
    {
        $errors = [];
        foreach ($fields as $field => $label) {
            if (empty(trim($data[$field] ?? ''))) {
                $errors[] = "$label is verplicht.";
            }
        }
        return $errors;
    }

    protected function validateEmail($email)
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }

    protected function validatePhone($phone)
    {
        return preg_match('/^[0-9+\-\s]+$/', $phone);
    }

    
}