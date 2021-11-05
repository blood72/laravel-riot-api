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

        // there is no parameter to modify
        if ($reflection->getNumberOfParameters() === 0 || isset($parameters['locale'])) {
            return;
        }

        $arguments = [];

        // fill in the parameters used by the method
        foreach ($reflection->getParameters() as $key => $parameter) {
            if (array_key_exists($key, $parameters)) {
                $arguments[$key] = $parameters[$key];
            }
            elseif (array_key_exists($parameter->getName(), $parameters)) {
                $arguments[$key] = $parameters[$parameter->getName()];
            }
            elseif ($parameter->getName() === 'locale') {
                $arguments[$key] = config('riot-api.locale');
            }
            else {
                $arguments[$key] = $parameter->getDefaultValue();
            }
        }

        $parameters = $arguments;
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
