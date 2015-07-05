<?php

    function stringify($param) {
            return str_pad($param, strlen($param) + 2, '"', STR_PAD_BOTH);
    }
    
    function implode_and($conditions) {
            return $this->implode_recursive($conditions, " AND ");
    }
    function implode_comma($conditions) {
            return $this->implode_recursive($conditions, ", ");
    }
    function implode_recursive($conditions, $glue) {
        if ($conditions != null) {
            $condition = array_shift($conditions);
            if ($condition == null) {
                return $this->implode_recursive($conditions, $glue);
            } else {
                return $condition . $this->implode_helper($conditions, $glue);
            }
        }
    }