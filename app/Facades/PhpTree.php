<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class PhpTree extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'php_tree';
    }
}