<?php

namespace Blood72\RiotAPI\Test;

use Blood72\RiotAPI\DataDragonAPIFacade;
use Blood72\RiotAPI\LeagueAPIFacade;
use Blood72\RiotAPI\RiotAPIServiceProvider;
use Orchestra\Testbench\TestCase as BaseCase;
use RiotAPI\LeagueAPI\Definitions\Region;

abstract class TestCase extends BaseCase
{
    /**
     * Get package providers.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [RiotAPIServiceProvider::class];
    }

    /**
     * Register the alias.
     *
     * @param \Illuminate\Foundation\Application  $app
     *
     * @return array
     */
    protected function getPackageAliases($app)
    {
        return [
            'LeagueAPI' => LeagueAPIFacade::class,
            'DataDragonAPI' => DataDragonAPIFacade::class,
        ];
    }

    /**
     * Define environment setup.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('riot-api.region', Region::KOREA);
    }
}
