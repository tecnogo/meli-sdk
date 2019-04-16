<?php

namespace Tecnogo\MeliSdk\Test\Unit;


use PHPUnit\Framework\TestCase;
use Tecnogo\MeliSdk\Test\Unit\Fixture\DummyAction;

class ActionTest extends TestCase
{
    public function testCacheKeyIsValid()
    {
        $action = new DummyAction();

        $this->assertNotEmpty($action->getCacheKey());
        $this->assertIsString($action->getCacheKey());
        $this->assertEquals($action->getCacheKey(), $action->getCacheKey(), 'Its always the same');
    }

    public function testActionResourceAltersCacheKey()
    {
        $firstAction = new DummyAction('blah');
        $secondAction = new DummyAction('baz');

        $this->assertNotEquals($firstAction->getCacheKey(), $secondAction->getCacheKey());
    }

    public function testActionPayloadAltersCacheKey()
    {
        $firstAction = new DummyAction('blah', ['a' => 1]);
        $secondAction = new DummyAction('blah'. ['a' => 2]);

        $this->assertNotEquals($firstAction->getCacheKey(), $secondAction->getCacheKey());
    }
}