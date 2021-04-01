<?php

namespace Blood72\Riot\Tests;

use Blood72\Riot\RiotAPIServiceProvider;
use Blood72\Riot\Proxies\LeagueAPIProxy as LeagueAPI;
use RiotAPI\DataDragonAPI\DataDragonAPI;

class ServiceProviderTest extends TestCase
{
    /** @test */
    public function it_is_possible_to_defer_a_provider()
    {
        /** @var \Illuminate\Support\ServiceProvider $provider */
        $provider = $this->getMockBuilder(RiotAPIServiceProvider::class)
            ->disableOriginalConstructor()
            ->setMethodsExcept(['isDeferred'])
            ->getMock();

        $actual = $provider->isDeferred();

        $this->assertFalse($actual);
    }

    /** @test */
    public function it_can_register_binding(): void
    {
        $this->assertInstanceOf(LeagueAPI::class, $this->app->get('league-api'));

        $this->assertInstanceOf(DataDragonAPI::class, $this->app->get('ddragon-api'));
    }

    /** @test */
    public function it_can_provide_services(): void
    {
        /** @var \Illuminate\Support\ServiceProvider $provider */
        $provider = $this->getMockBuilder(RiotAPIServiceProvider::class)
            ->disableOriginalConstructor()
            ->setMethodsExcept(['provides'])
            ->getMock();

        $actual = $provider->provides();

        $this->assertContains('league-api', $actual);
        $this->assertContains('ddragon-api', $actual);
    }
}
