<?php

    function stringify($param) {
            return str_pad($param, strlen($param) + 2, '"', STR_PAD_BOTH);
    }
    
    function implode_and($conditions) {
            return implode_recursive($conditions, " AND ");
    }
    function implode_comma($conditions) {
            return implode_recursive($conditions, ", ");
    }
    function implode_recursive($conditions, $glue) {
        if ($conditions != null) {
            $condition = array_shift($conditions);
            if ($condition == null) {
                return implode_recursive($conditions, $glue);
            } else {
                return $condition . implode_helper($conditions, $glue);
            }
        }
    }
    function implode_helper($conditions, $glue) {
    if ($conditions != null) {    
        $condition = array_shift($conditions);
        if ($condition == null) {
            return implode_helper($conditions, $glue);
        } else {
            return $glue . $condition . implode_helper($conditions, $glue);
        }
    }    
}