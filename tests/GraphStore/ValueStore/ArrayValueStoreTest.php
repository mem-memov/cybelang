<?php

namespace MemMemov\GraphStore\ValueStore;

class ArrayValueStoreTest extends \PHPUnit\Framework\TestCase
{
    /** @var Hash|\PHPUnit_Framework_MockObject_MockObject */
    protected $hash;

    protected function setUp()
    {
        $this->hash = $this->createMock(Hash::class);
    }

    public function testItBindsKeyAndValue()
    {
        $store = new ArrayValueStore($this->hash);

        $this->hash->expects(self::once())
            ->method('create')
            ->with('some value')
            ->willReturn('5946210c9e93ae37891dfe96c3e39614');

        $store->bind('1', 'some value');
    }

    public function testItProvidesKeyByValue()
    {
        $store = new ArrayValueStore($this->hash);

        $this->hash->expects(self::exactly(2))
            ->method('create')
            ->with('some value')
            ->willReturn('5946210c9e93ae37891dfe96c3e39614');

        $store->bind('1', 'some value');
        $result = $store->getKey('some value');

        $this->assertEquals('1', $result);
    }

    public function testItProvidesValueByKey()
    {
        $store = new ArrayValueStore($this->hash);

        $store->bind('1', 'some value');
        $result = $store->getValue('1');

        $this->assertEquals('some value', $result);
    }
}