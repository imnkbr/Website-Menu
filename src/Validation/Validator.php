<?php

namespace Src\Validation;

class Validator
{
    public static function validate($data)
    {
        $errors = [];

        if (empty($data['name'])) {
            $errors[] = 'Name is required';
        }

        if (empty($data['url'])) {
            $errors[] = 'URL is required';
        } elseif (!filter_var($data['url'], FILTER_VALIDATE_URL)) {
            $errors[] = 'Invalid URL format';
        }

        return $errors;
    }
}
