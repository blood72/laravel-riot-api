<?php

namespace Blood72\Riot\Tests;

use Blood72\Riot\Facades\DataDragonAPI as DataDragonAPIFacade;
use Blood72\Riot\Facades\LeagueAPI as LeagueAPIFacade;
use RiotAPI\DataDragonAPI\DataDragonAPI;
use RiotAPI\LeagueAPI\LeagueAPI;

class FacadeTest extends TestCase
{
    /** @test */
    public function it_resolve_ddragon_api_facade()
    {
        $this->assertTrue(class_exists('DataDragonAPI'));

        $actual = DataDragonAPIFacade::getFacadeRoot();

        $this->assertInstanceOf(DataDragonAPI::class, $actual);
    }

    /** @test */
    public function it_resolve_league_api_facade()
    {
        $this->assertTrue(class_exists('LeagueAPI'));

        $actual = LeagueAPIFacade::getFacadeRoot();

        $this->assertInstanceOf(LeagueAPI::class, $actual);
    }
}
