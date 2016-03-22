<?php
if(!function_exists('singular_array_transform')){
    function singular_array_transform($db_array, $key, $value){
        $array = array();
        foreach ($db_array as $db_array_entry){
            $array[$db_array_entry[$key]] = $db_array_entry[$value];
        }
        return $array;
    }
}