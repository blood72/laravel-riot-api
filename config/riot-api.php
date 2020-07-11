<?php

return [
    'key' => env('RIOT_API_KEY'),

    'region' => env('RIOT_API_REGION'),

    'cache' => env('RIOT_API_CACHE', true),

    'locale' => env('RIOT_API_LOCALE', 'en_US'),

    'league' => [
        'cache_namespace' => \RiotAPI\LeagueAPI\Definitions\Cache::LEAGUEAPI_NAMESPACE,
        'ddragon_linking' => env('RIOT_API_LEAGUE_LINKING', true),
        'settings' => [
            //
        ],
    ],

    'ddragon' => [
        'cache_namespace' => \RiotAPI\LeagueAPI\Definitions\Cache::DATADRAGON_NAMESPACE,
        'settings' => [
            //
        ],
    ],
];
