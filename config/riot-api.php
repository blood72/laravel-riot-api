<?php

return [
    'key' => env('RIOT_API_KEY'),

    'region' => env('RIOT_API_REGION', \RiotAPI\Base\Definitions\Region::NORTH_AMERICA),

    'cache' => env('RIOT_API_CACHE', true),

    'locale' => env('RIOT_API_LOCALE', 'en_US'),

    'league' => [
        'ddragon_linking' => env('RIOT_API_LEAGUE_LINKING', true),
        'settings' => [
            //
        ],
    ],

    'ddragon' => [
        'settings' => [
            //
        ],
    ],
];
