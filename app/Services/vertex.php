<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 2016-02-09
 * Time: 00:49
 */

namespace App\Services;


class vertex
{
    public $key = null;
    public $color = 'white';
    public $distance = -1;  // infinite

    public function __construct($key)
    {
        $this->key = $key;
    }
}