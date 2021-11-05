<?php

namespace Blood72\Riot\Tests;

use ReflectionMethod;

class APITest extends TestCase
{
    /**
     * @test
     * @dataProvider dataProvider
     */
    public function locale_should_be_set_implicitly($parameters, $expect)
    {
        $api = $this->app->get('league-api');

        try {
            $reflection = new ReflectionMethod($api, 'modifyParameters');
            $reflection->setAccessible(true);

            $reflection->invokeArgs($api, ['getStaticItems', &$parameters]);
        } catch (\Throwable $e) {
            $this->fail(get_class($e).': '.$e->getMessage());
        }

        $this->assertTrue(in_array($expect ?: $this->app['config']->get('riot-api.locale'), $parameters)); // ko_KR
    }

    /**
     * @return array
     */
    public function dataProvider(): array
    {
        return [
            [[], null],
            [['en_US'], 'en_US'],
            [['locale' => 'ja_JP'], 'ja_JP'],
        ];
    }
}
