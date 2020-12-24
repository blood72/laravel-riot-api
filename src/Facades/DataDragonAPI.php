<?php

namespace Blood72\Riot\Facades;

use Illuminate\Support\Facades\Facade;

class DataDragonAPI extends Facade
{
    /**
     * {@inheritDoc}
     */
    protected static function getFacadeAccessor()
    {
        return 'ddragon-api';
    }
}
