<?php

namespace MemMemov\Cybelang\GraphStore;

use PHPUnit\Framework\TestCase;

class GraphStoreTest extends TestCase
{
    /** @var NodeStore|\PHPUnit_Framework_MockObject_MockObject */
    protected $nodeStore;
    /** @var ValueStore|\PHPUnit_Framework_MockObject_MockObject */
    protected $valueStore;


    protected function setUp()
    {
        $this->nodeStore = $this->createMock(NodeStore::class);
        $this->valueStore = $this->createMock(ValueStore::class);
    }

    public function testItCreatesNode()
    {
        $graphStore = new GraphStore($this->nodeStore, $this->valueStore);

        $id = 765;

        $this->nodeStore->expects($this->once())
            ->method('create')
            ->willReturn($id);

        $result = $graphStore->createNode();

        $this->assertEquals($id, $result);
    }

    public function testItReadsNode()
    {
        $graphStore = new GraphStore($this->nodeStore, $this->valueStore);

        $id = 765;
        $ids = [5, 7, 99];

        $this->nodeStore->expects($this->once())
            ->method('read')
            ->with($id)
            ->willReturn($ids);

        $result = $graphStore->readNode($id);

        $this->assertEquals($ids, $result);
    }

    public function testItConnectsNodes()
    {
        $graphStore = new GraphStore($this->nodeStore, $this->valueStore);

        $fromId = 754;
        $toId = 5;

        $this->nodeStore->expects($this->once())
            ->method('connect')
            ->with($fromId, $toId);

        $graphStore->connectNodes($fromId, $toId);
    }

    public function testItReadsExistingNodeForValue()
    {
        $graphStore = new GraphStore($this->nodeStore, $this->valueStore);

        $id = 765;
        $value = 'some value';

        $this->valueStore->expects($this->once())
            ->method('hasValue')
            ->with($value)
            ->willReturn(true);

        $this->valueStore->expects($this->once())
            ->method('key')
            ->with($value)
            ->willReturn((string)$id);

        $result = $graphStore->provideNode($value);

        $this->assertEquals($id, $result);
    }

    public function testItCreatesNewNodeForValue()
    {
        $graphStore = new GraphStore($this->nodeStore, $this->valueStore);

        $id = 765;
        $value = 'some value';

        $this->valueStore->expects($this->once())
            ->method('hasValue')
            ->with($value)
            ->willReturn(false);

        $this->nodeStore->expects($this->once())
            ->method('create')
            ->willReturn($id);

        $this->valueStore->expects($this->once())
            ->method('bind')
            ->with((string)$id, $value);

        $result = $graphStore->provideNode($value);

        $this->assertEquals($id, $result);
    }

    public function testItReadsValueOfNode()
    {
        $graphStore = new GraphStore($this->nodeStore, $this->valueStore);

        $id = 765;
        $value = 'some value';

        $this->valueStore->expects($this->once())
            ->method('hasKey')
            ->with((string)$id)
            ->willReturn(true);

        $this->valueStore->expects($this->once())
            ->method('value')
            ->with((string)$id)
            ->willReturn($value);

        $result = $graphStore->readValue($id);

        $this->assertEquals($value, $result);
    }

    public function testItDeniesReadingEmptyNode()
    {
        $graphStore = new GraphStore($this->nodeStore, $this->valueStore);

        $id = 765;

        $this->valueStore->expects($this->once())
            ->method('hasKey')
            ->with((string)$id)
            ->willReturn(false);

        $this->expectException(SomeNodesHaveNoValue::class);

        $graphStore->readValue($id);
    }

    public function testItFindsCommonSubnodes()
    {
        $graphStore = new GraphStore($this->nodeStore, $this->valueStore);

        $ids = [5, 7, 99];
        $commonSubIds = [2, 78];

        $this->nodeStore->expects($this->once())
            ->method('intersect')
            ->with($ids)
            ->willReturn($commonSubIds);

        $result = $graphStore->commonNodes($ids);

        $this->assertEquals($commonSubIds, $result);
    }
}