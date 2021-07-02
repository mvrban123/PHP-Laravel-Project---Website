<?php

namespace App\Http\Sanitizers;

class BaseSanitizer 
{
    public static function sanitize($input_data)
    {
        array_walk_recursive($input_data, function(&$input_data) 
        {
            if (is_array($input_data) || is_object($input_data)) 
            {
                $input_data = self::sanitize($input_data);
            }

            else 
            {
                $input_data = self::pretransform_input($input_data);
                $input_data = strip_tags($input_data);
            }
        });

        return $input_data;
    }
    
    private static function pretransform_input($input_data)
    {
        $pretransform_type_map = array(
            "boolean" => function($boolean_data) { return self::transform_boolean($boolean_data); }
        );

        if (array_key_exists(
                gettype($input_data),
                $pretransform_type_map
        ))
        {
            $input_data = $pretransform_type_map[gettype($input_data)]($input_data);
        }

        return $input_data;
    }


    private static function transform_boolean($boolean_data)
    {
        return (int)$boolean_data;
    }

}