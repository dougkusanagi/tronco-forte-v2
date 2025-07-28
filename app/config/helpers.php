<?php

if (!function_exists('d')) {
    /**
     * Dump one or more variables.
     * 
     * @param mixed ...$var
     */
    function d(...$var) {
        foreach ($var as $v) {
            echo "<pre>";
            var_dump($v);
            echo "</pre>";
        }
    }
}

if (!function_exists('dd')) {
    /**
     * Dump one or more variables and die.
     * 
     * @param mixed ...$var
     */
    function dd(...$var) {
        d($var);
        die();
    }
}