<?php

namespace Blood72\RiotAPI\Test;

use Blood72\RiotAPI\RiotAPIServiceProvider;
use RiotAPI\DataDragonAPI\DataDragonAPI;
use RiotAPI\LeagueAPI\LeagueAPI;

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

        $this->assertTrue($actual);
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
