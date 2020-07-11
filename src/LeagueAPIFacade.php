<?php

namespace Blood72\RiotAPI;

use Illuminate\Support\Facades\Facade;

class LeagueAPIFacade extends Facade
{
    /**
     * {@inheritDoc}
     */
    protected static function getFacadeAccessor()
    {
        return 'league-api';
    }
}
