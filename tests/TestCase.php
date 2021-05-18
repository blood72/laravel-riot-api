<?php

namespace Blood72\Riot\Tests;

use Blood72\Riot\Facades\DataDragonAPI;
use Blood72\Riot\Facades\LeagueAPI;
use Blood72\Riot\RiotAPIServiceProvider;
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
            'LeagueAPI' => LeagueAPI::class,
            'DataDragonAPI' => DataDragonAPI::class,
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
        $app['config']->set('riot-api.locale', 'ko_KR');
        $app['config']->set('riot-api.region', Region::KOREA);
    }
}
