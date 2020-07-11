<?php

namespace Blood72\RiotAPI;

use Illuminate\Support\Facades\Facade;

class DataDragonAPIFacade extends Facade
{
    /**
     * {@inheritDoc}
     */
    protected static function getFacadeAccessor()
    {
        return 'ddragon-api';
    }
}
