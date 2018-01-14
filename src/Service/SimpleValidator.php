<?php
namespace App\Service;

class SimpleValidator
{

    public function validate(Array $params)
    {
        foreach($params as $param)
        {
            if(!$param || !is_numeric($param))
            {
                return false;
            }
        }
        return true;
    }

}
