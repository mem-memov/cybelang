<?php

namespace MemMemov\Cybelang\GraphStore\NodeStore;

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

        $this->assertEquals(1, $result);
    }

    public function testItConnectsNodes()
    {
        $store = new ArrayNodeStore($this->path);

        $fromId = $store->create();
        $toId = $store->create();

        $store->connect($fromId, $toId);

        $result = $store->read($fromId);

        $this->assertContains($toId, $result);
    }

    public function testItDoesNotConnectNodesAlreadyConnected()
    {
        $store = new ArrayNodeStore($this->path);

        $fromId = $store->create();
        $toId = $store->create();

        $store->connect($fromId, $toId);
        $store->connect($fromId, $toId);
        $store->connect($fromId, $toId);
        $store->connect($fromId, $toId);

        unset($store);

        $array = unserialize(file_get_contents($this->path));

        $this->assertEquals([
            1 => [2],
            2 => []
        ], $array);
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

        $this->assertEquals([$toId_1, $toId_2], $result);
    }

    public function testItChecksNodeConnected()
    {
        $store = new ArrayNodeStore($this->path);

        $fromId = $store->create();
        $toId = $store->create();

        $store->connect($fromId, $toId);

        $result = $store->contains($fromId, $toId);

        $this->assertTrue($result);
    }

    public function testItChecksNodeNotConnected()
    {
        $store = new ArrayNodeStore($this->path);

        $fromId = $store->create();
        $toId = $store->create();

        $result = $store->contains($fromId, $toId);

        $this->assertFalse($result);
    }

    public function testItReadsPersistedNodes()
    {
        $store = new ArrayNodeStore($this->path);
        $fromId = $store->create();
        $toId = $store->create();
        $store->connect($fromId, $toId);
        unset($store);

        $store_1 = new ArrayNodeStore($this->path);

        $result = $store_1->read($fromId);

        $this->assertEquals([$toId], $result);
    }

    public function testItIntersectsSubnodes()
    {
        $store = new ArrayNodeStore($this->path);

        $toId_1 = $store->create();
        $toId_2 = $store->create();
        $toId_3 = $store->create();
        $toId_4 = $store->create();
        $toId_5 = $store->create();

        $store->connect($toId_1, $toId_3);
        $store->connect($toId_1, $toId_4);
        $store->connect($toId_2, $toId_3);
        $store->connect($toId_2, $toId_5);

        $result = $store->intersect([$toId_1, $toId_2]);

        $this->assertEquals([$toId_3], $result);
    }
}