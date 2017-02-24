<?php

namespace MemMemov\GraphStore\ValueStore;

use org\bovigo\vfs\vfsStream;
use PHPUnit\Framework\TestCase;

class ArrayValueStoreTest extends TestCase
{
    /** @var Hash|\PHPUnit_Framework_MockObject_MockObject */
    protected $hash;
    /** @var string */
    protected $keyPath;
    /** @var string */
    protected $valuePath;

    protected function setUp()
    {
        $this->hash = $this->createMock(Hash::class);

        vfsStream::setup('rootDirectory', null, [
            'key_store.txt' => '',
            'value_store.txt' => ''
        ]);

        $this->keyPath = vfsStream::url('rootDirectory/key_store.txt');
        $this->valuePath = vfsStream::url('rootDirectory/value_store.txt');
    }

    public function testItBindsKeyAndValue()
    {
        $store = new ArrayValueStore($this->hash, $this->keyPath, $this->valuePath);

        $this->hash->expects($this->once())
            ->method('create')
            ->with('some value')
            ->willReturn('5946210c9e93ae37891dfe96c3e39614');

        $store->bind('1', 'some value');
    }

    public function testItProvidesKeyByValue()
    {
        $store = new ArrayValueStore($this->hash, $this->keyPath, $this->valuePath);

        $this->hash->expects($this->exactly(2))
            ->method('create')
            ->with('some value')
            ->willReturn('5946210c9e93ae37891dfe96c3e39614');

        $store->bind('1', 'some value');
        $result = $store->key('some value');

        $this->assertEquals('1', $result);
    }

    public function testItProvidesValueByKey()
    {
        $store = new ArrayValueStore($this->hash, $this->keyPath, $this->valuePath);

        $store->bind('1', 'some value');
        $result = $store->value('1');

        $this->assertEquals('some value', $result);
    }

    public function testItChecksItHasGotAValue()
    {
        $store = new ArrayValueStore($this->hash, $this->keyPath, $this->valuePath);

        $store->bind('1', 'some value');

        $result =  $store->hasValue('some value');

        $this->assertTrue($result);
    }

    public function testItChecksItHasNotGotAValue()
    {
        $store = new ArrayValueStore($this->hash, $this->keyPath, $this->valuePath);

        $result =  $store->hasValue('some value');

        $this->assertFalse($result);
    }

    public function testItChecksItHasGotAKey()
    {
        $store = new ArrayValueStore($this->hash, $this->keyPath, $this->valuePath);

        $store->bind('1', 'some value');

        $result =  $store->hasKey('1');

        $this->assertTrue($result);
    }

    public function testItChecksItHasNotGotAKey()
    {
        $store = new ArrayValueStore($this->hash, $this->keyPath, $this->valuePath);

        $result =  $store->hasKey('1');

        $this->assertFalse($result);
    }
}