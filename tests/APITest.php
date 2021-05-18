<?php

namespace Blood72\Riot\Tests;

use ReflectionMethod;

class APITest extends TestCase
{
    /** @test */
    public function locale_should_be_set_implicitly()
    {
        $api = $this->app->get('league-api');
        $arguments = [];

        try {
            $reflection = new ReflectionMethod($api, 'modifyParameters');
            $reflection->setAccessible(true);

            $reflection->invokeArgs($api, ['getStaticItems', &$arguments]);
        } catch (\Throwable $e) {
            $this->fail(get_class($e).': '.$e->getMessage());
        }

        $this->assertTrue(in_array($this->app['config']->get('riot-api.locale'), $arguments)); // ko_KR
    }
}
