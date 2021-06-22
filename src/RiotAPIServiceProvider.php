<?php

namespace Blood72\Riot;

use Blood72\Riot\Proxies\LeagueAPIProxy;
use Illuminate\Container\Container;
use Illuminate\Support\ServiceProvider;
use RiotAPI\DataDragonAPI\DataDragonAPI;
use RiotAPI\LeagueAPI\LeagueAPI;

class RiotAPIServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/riot-api.php' => config_path("riot-api.php"),
            ], 'config');
        }
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/riot-api.php', 'riot-api');

        // support Laravel IDE Helper to work with @mixin properly
        if (class_exists('Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider') && app()->runningInConsole()) {
            config([
                'ide-helper.extra.LeagueAPI' => ['RiotAPI\LeagueAPI\LeagueAPI'],
            ]);
        }

        $this->resolveLeagueAPI();

        $this->resolveDataDragonAPI();
    }

    /**
     * Resolve League of Legends API.
     *
     * @see LeagueAPI
     * @return void
     */
    protected function resolveLeagueAPI()
    {
        $this->app->singleton('league-api', function (Container $app) {
            $api = new LeagueAPI(array_merge([
                LeagueAPI::SET_KEY => $app['config']->get('riot-api.key'),
                LeagueAPI::SET_REGION => $app['config']->get('riot-api.region'),

                LeagueAPI::SET_DATADRAGON_INIT => $app['config']->get('riot-api.league.ddragon_linking'),
                LeagueAPI::SET_DATADRAGON_PARAMS => $app['config']->get('riot-api.ddragon.settings'),
                LeagueAPI::SET_STATICDATA_LINKING => $app['config']->get('riot-api.league.ddragon_linking'),
                LeagueAPI::SET_STATICDATA_LOCALE => $app['config']->get('riot-api.locale'),

                LeagueAPI::SET_CACHE_CALLS => $app['config']->get('riot-api.cache'),
                LeagueAPI::SET_CACHE_RATELIMIT => $app['config']->get('riot-api.cache'),
                LeagueAPI::SET_CACHE_PROVIDER => get_class($app['cache.psr6']),
                LeagueAPI::SET_CACHE_PROVIDER_PARAMS => [
                    $app['cache.store'],
                    $app['config']->get('riot-api.league.cache_namespace', 'league-api'),
                ],
                LeagueAPI::SET_DD_CACHE_PROVIDER_PARAMS => [
                    $app['cache.store'],
                    $app['config']->get('riot-api.ddragon.cache_namespace', 'ddragon-api'),
                ],
            ], $app['config']->get('riot-api.league.settings')));

            return new LeagueAPIProxy($api);
        });
    }

    /**
     * Resolve Riot DataDragon API.
     *
     * @see DataDragonAPI
     * @return void
     */
    protected function resolveDataDragonAPI()
    {
        $this->app->singleton('ddragon-api', function (Container $app) {
            $customSettings = $app['config']->get('riot-api.ddragon.settings');

            if ($app->resolved('league-api')) {
                DataDragonAPI::initByRealmObject(app('league-api')->getStaticRealm(), $customSettings);
            } elseif (! $app->resolved('league-api') || ! $app['config']->get('riot-api.league.ddragon_linking')) {
                DataDragonAPI::initByCdn($customSettings);
            }

            if ($app['config']->get('riot-api.cache')) {
                $cacheProvider = get_class($app['cache.psr6']);
                $namespace = $app['config']->get('riot-api.ddragon.cache_namespace', 'ddragon-api');

                $cache = new $cacheProvider($app['cache.store'], $namespace);

                DataDragonAPI::setCacheInterface($cache);
            }

            return new DataDragonAPI;
        });

        if ($this->app['config']->get('riot-api.league.ddragon_linking')) {
            $this->app->afterResolving('league-api', function () {
                app('ddragon-api')->checkInit();
            });
        }
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['league-api', 'ddragon-api'];
    }
}
