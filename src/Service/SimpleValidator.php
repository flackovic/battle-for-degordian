<?php

namespace App\Service;

class SimpleValidator
{
    public function validate(array $params)
    {
        foreach ($params as $param) {
            if (!$param || !is_numeric($param)) {
                return false;
            }
        }

        return true;
    }
}
