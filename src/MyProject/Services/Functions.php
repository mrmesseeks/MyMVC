<?php
/**
 * Created by PhpStorm.
 * User: Artem
 * Date: 14.11.2018
 * Time: 18:33
 */

namespace MyProject\Services;


class Functions
{
    public function vardump($var)
    {
        echo '<pre>';
        var_dump($var);
        echo '</pre>';
    }
}