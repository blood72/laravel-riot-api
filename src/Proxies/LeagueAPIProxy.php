<?php

namespace Blood72\Riot\Proxies;

use ReflectionMethod;
use RiotAPI\LeagueAPI\LeagueAPI;

/**
 * @mixin LeagueAPI
 */
class LeagueAPIProxy
{
    /** @var LeagueAPI */
    protected $api;

    /**
     * @param LeagueAPI $api
     * @return void
     */
    public function __construct(LeagueAPI $api)
    {
        $this->api = $api;
    }

    /**
     * Set 'locale' parameter to configuration value if the param was not passed
     *
     * @param string $method
     * @param mixed  $parameters
     * @return void
     * @throws \ReflectionException
     */
    protected function modifyLocaleParameter(string $method, &$parameters)
    {
        $reflection = new ReflectionMethod($this->api, $method);

        foreach ($reflection->getParameters() as $key => $parameter) {
            if (array_key_exists($key, $parameters)) {
                continue;
            }

            if ($parameter->getName() === 'locale') {
                $parameters[$key] = config('riot-api.locale');

                break;
            }

            if ($parameter->isOptional()) {
                $parameters[$key] = $parameter->getDefaultValue();
            }
        }
    }

    /**
     * @param string $method
     * @param mixed  $parameters
     * @return void
     * @throws \ReflectionException
     */
    protected function modifyParameters(string $method, &$parameters)
    {
        $this->modifyLocaleParameter($method, $parameters);
    }

    /**
     * @param $method
     * @param $parameters
     * @return mixed
     * @throws \ReflectionException
     */
    public function __call($method, $parameters)
    {
        if (method_exists($this->api, $method)) {
            $this->modifyParameters($method, $parameters);
        }

        return $this->api->$method(...$parameters);
    }
}
