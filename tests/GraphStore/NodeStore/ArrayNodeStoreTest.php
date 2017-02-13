<?php

namespace MemMemov\GraphStore\NodeStore;

use org\bovigo\vfs\vfsStream;
use PHPUnit\Framework\TestCase;

class ArrayNodeStoreTest extends TestCase
{
    /** @var string */
    protected $path;

    protected function setUp()
    {
        vfsStream::setup('rootDirectory', null, [
            'node_store.txt' => ''
        ]);

        $this->path = vfsStream::url('rootDirectory/node_store.txt');
    }

    public function testItCreatesNode()
    {
        $store = new ArrayNodeStore($this->path);

        $result = $store->create();

        self::assertEquals(1, $result);
    }

    public function testItConnectsNodes()
    {
        $store = new ArrayNodeStore($this->path);

        $fromId = $store->create();
        $toId = $store->create();

        $store->connect($fromId, $toId);

        $result = $store->read($fromId);

        self::assertContains($toId, $result);
    }

    public function testItReadsNode()
    {
        $store = new ArrayNodeStore($this->path);

        $fromId = $store->create();

        $toId_1 = $store->create();
        $store->connect($fromId, $toId_1);

        $toId_2 = $store->create();
        $store->connect($fromId, $toId_2);

        $result = $store->read($fromId);

        self::assertEquals([$toId_1, $toId_2], $result);
    }

    public function testItChecksNodeConnected()
    {
        $store = new ArrayNodeStore($this->path);

        $fromId = $store->create();
        $toId = $store->create();

        $store->connect($fromId, $toId);

        $result = $store->contains($fromId, $toId);

        self::assertTrue($result);
    }

    public function testItChecksNodeNotConnected()
    {
        $store = new ArrayNodeStore($this->path);

        $fromId = $store->create();
        $toId = $store->create();

        $result = $store->contains($fromId, $toId);

        self::assertFalse($result);
    }
}