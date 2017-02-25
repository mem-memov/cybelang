<?php

namespace MemMemov\Cybelang\SpaceGraph;

use PHPUnit\Framework\TestCase;

class SpacesTest extends TestCase
{
    /** @var Store|\PHPUnit_Framework_MockObject_MockObject */
    protected $store;

    protected function setUp()
    {
        $this->store = $this->createMock(Store::class);
    }
}