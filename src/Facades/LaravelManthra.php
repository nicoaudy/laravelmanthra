<?php

namespace NicoAudy\LaravelManthra\Facades;

use Illuminate\Support\Facades\Facade;

class LaravelManthra extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'laravelmanthra';
    }
}
