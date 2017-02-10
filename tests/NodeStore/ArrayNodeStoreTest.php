<?php

namespace MemMemov\NodeStore;

class ArrayNodeStoreTest extends \PHPUnit_Framework_TestCase
{
    public function testItCreatesNode()
    {
        $store = new ArrayNodeStore();

        $result = $store->create();

        $this->assertEquals(1, $result);
    }

    public function testItConnectsNodes()
    {
        $store = new ArrayNodeStore();

        $fromId = $store->create();
        $toId = $store->create();

        $store->connect($fromId, $toId);

        $result = $store->read($fromId);

        $this->assertContains($toId, $result);
    }

    public function testItReadsNode()
    {
        $store = new ArrayNodeStore();

        $fromId = $store->create();

        $toId_1 = $store->create();
        $store->connect($fromId, $toId_1);

        $toId_2 = $store->create();
        $store->connect($fromId, $toId_2);

        $result = $store->read($fromId);

        $this->assertEquals([$toId_1, $toId_2], $result);
    }

    public function testItChecksNodeConnected()
    {
        $store = new ArrayNodeStore();

        $fromId = $store->create();
        $toId = $store->create();

        $store->connect($fromId, $toId);

        $result = $store->contains($fromId, $toId);

        $this->assertTrue($result);
    }

    public function testItChecksNodeNotConnected()
    {
        $store = new ArrayNodeStore();

        $fromId = $store->create();
        $toId = $store->create();

        $result = $store->contains($fromId, $toId);

        $this->assertFalse($result);
    }
}