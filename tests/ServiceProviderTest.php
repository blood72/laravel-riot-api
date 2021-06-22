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
            ->onlyMethods([])
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
            ->onlyMethods([])
            ->getMock();

        $actual = $provider->provides();

        $this->assertContains('league-api', $actual);
        $this->assertContains('ddragon-api', $actual);
    }

    /** @test */
    public function it_should_be_resolved_when_static_data_linking_is_enabled(): void
    {
        config()->set('riot-api.league.ddragon_linking', true);

        app('league-api');

        try {
            DataDragonAPI::checkInit();
        } catch (\RiotAPI\DataDragonAPI\Exceptions\SettingsException $e) {
            $this->fail('DataDragonAPI class was not initialized');
        }

        $this->expectNotToPerformAssertions();
    }
}
