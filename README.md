# Laravel Riot API

This is the [parent project](https://github.com/dolejska-daniel/riot-api)'s wrapper for Laravel.

It supports initialize LeagueAPI and DataDragonAPI and adjusted to use Laravel cache driver.

## Index

- [Requirement](#requirement)
- [Installation](#installation)
- [Configuration](#configuration)
- [Usage](#usage)
- [Reference](#reference)
- [License](#license)

## Requirement

- PHP >= 7.3
- Laravel ^7.0 | ^8.0
- dolejska-daniel/riot-api ^5.0.0

## Installation

Install using the composer.

```bash
composer require blood72/laravel-riot-api
```

You can publish [config file](./config/riot-api.php).

```bash
php artisan vendor:publish --provider="Blood72\RiotAPI\RiotAPIServiceProvider"
```

## Configuration

It requires ```RIOT_API_KEY``` and ```RIOT_API_REGION```

```php
// in riot-api.php
'key' => env('RIOT_API_KEY'),
'region' => env('RIOT_API_REGION', 'na'),
```

You can turn ON/OFF Laravel cache driver \(default is ```true```)

```php
'cache' => env('RIOT_API_CACHE', true),
```

By default, ```RIOT_API_LEAGUE_LINKING``` option is enabled.  
It brings static data together while using LeagueAPI and automatically initializes DataDragonAPI.

If you don't to use these default options, you can overwrite or add them through the settings options.

```php
'league' => [
    // ...
    'settings' => [
        //
    ],
],

'ddragon' => [
    // ...
    'settings' => [
        //
    ],
],
```

## Usage

You can use Facade or resolve methods

to use LeagueAPI

```php
$summoner = app('league-api')->getSummonerByName('__SOMEONE__');
$matchList = LeagueAPI::getMatchlistByAccount($summoner->accountId);
```

to use DataDragonAPI

```php
$icon = resolve('ddragon-api')->getChampionIcon('Diana');
$splash = DataDragonAPI::getChampionSplashUrl('Diana', 11);
```

Other uses can be found on the [wiki](https://github.com/dolejska-daniel/riot-api/wiki) of the [parent project](https://github.com/dolejska-daniel/riot-api).

## Reference

- Daniel Dolejška's [RiotAPI PHP7 wrapper](https://github.com/dolejska-daniel/riot-api)

## License

This package is open-sourced software licensed under the MIT license.
