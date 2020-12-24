<?php

namespace Blood72\Riot\Facades;

use Illuminate\Support\Facades\Facade;

class LeagueAPI extends Facade
{
    /**
     * {@inheritDoc}
     */
    protected static function getFacadeAccessor()
    {
        return 'league-api';
    }
}
