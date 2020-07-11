<?php

namespace Blood72\RiotAPI\Test;

use Blood72\RiotAPI\DataDragonAPIFacade;
use Blood72\RiotAPI\LeagueAPIFacade;
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
