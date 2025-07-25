<?php

if (!function_exists('dump')) {
    /**
     * Dump one or more variables.
     * 
     * @param mixed ...$var
     */
    function dump(...$var) {
        foreach ($var as $v) {
            var_dump($v);
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
        dump($var);
        die();
    }
}