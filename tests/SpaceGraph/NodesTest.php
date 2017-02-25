<?php

namespace MemMemov\SpaceGraph;

use PHPUnit\Framework\TestCase;

class NodesTest extends TestCase
{
    /** @var Store|\PHPUnit_Framework_MockObject_MockObject */
    protected $store;
    /** @var NodeCache|\PHPUnit_Framework_MockObject_MockObject */
    protected $nodeCache;

    protected function setUp()
    {
        $this->store = $this->createMock(Store::class);
        $this->nodeCache = $this->createMock(NodeCache::class);
    }

    public function testItCreatesNode()
    {
        $nodes = new Nodes($this->store, $this->nodeCache);

        $this->store->expects($this->once())
            ->method('createNode')
            ->willReturn(22);

        $this->nodeCache->expects($this->once())
            ->method('set');

        $result = $nodes->create();

        $this->assertInstanceOf(Node::class, $result);
    }

    public function testItCreatesCommonNode()
    {
        $nodes = $this->getMockBuilder(Nodes::class)
            ->setMethods(['create'])
            ->setConstructorArgs([$this->store, $this->nodeCache])
            ->getMock();

        $commonNode = $this->createMock(Node::class);

        $nodes->expects($this->once())
            ->method('create')
            ->willReturn($commonNode);

        $node_1 = $this->createMock(Node::class);
        $node_1->expects($this->once())
            ->method('add')
            ->with($commonNode);

        $node_2 = $this->createMock(Node::class);
        $node_2->expects($this->once())
            ->method('add')
            ->with($commonNode);

        $commonNode->expects($this->exactly(2))
            ->method('add')
            ->withConsecutive([$node_1], [$node_2]);

        $result = $nodes->createCommonNode([$node_1, $node_2]);

        $this->assertSame($commonNode, $result);
    }

    public function testItReadsFromCache()
    {
        $nodes = new Nodes($this->store, $this->nodeCache);

        $id = 9674637;

        $this->nodeCache->expects($this->once())
            ->method('has')
            ->with($id)
            ->willReturn(true);

        $node = $this->createMock(Node::class);

        $this->nodeCache->expects($this->once())
            ->method('get')
            ->with($id)
            ->willReturn($node);

        $result = $nodes->read($id);

        $this->assertSame($node, $result);
    }

    public function testItReadsFromStore()
    {
        $nodes = new Nodes($this->store, $this->nodeCache);

        $id = 9674637;
        $ids = [45425, 67, 584, 2456];

        $this->nodeCache->expects($this->once())
            ->method('has')
            ->with($id)
            ->willReturn(false);

        $this->store->expects($this->once())
            ->method('readNode')
            ->with($id)
            ->willReturn($ids);

        $this->nodeCache->expects($this->once())
            ->method('set')
            ->with($this->isInstanceOf(Node::class));

        $result = $nodes->read($id);

        $this->assertInstanceOf(Node::class, $result);
    }

    public function testItReadsManyNodes()
    {
        $nodes = $this->getMockBuilder(Nodes::class)
            ->setMethods(['read'])
            ->setConstructorArgs([$this->store, $this->nodeCache])
            ->getMock();

        $ids = [45425, 67];
        $node_1 = $this->createMock(Node::class);
        $node_2 = $this->createMock(Node::class);

        $nodes->expects($this->exactly(2))
            ->method('read')
            ->withConsecutive([45425], [67])
            ->will($this->onConsecutiveCalls($node_1, $node_2));

        $result = $nodes->readMany($ids);

        $this->assertSame([$node_1, $node_2], $result);
    }

    public function testItReadsNodeForValue()
    {
        $nodes = $this->getMockBuilder(Nodes::class)
            ->setMethods(['read'])
            ->setConstructorArgs([$this->store, $this->nodeCache])
            ->getMock();

        $id = 9674637;
        $value = 'some value';

        $this->store->expects($this->once())
            ->method('provideNode')
            ->with($value)
            ->willReturn($id);

        $node = $this->createMock(Node::class);

        $nodes->expects($this->once())
            ->method('read')
            ->with($id)
            ->willReturn($node);

        $result = $nodes->nodeForValue($value);

        $this->assertSame($node, $result);
    }

    public function testItReadsValueOfNode()
    {
        $nodes = new Nodes($this->store, $this->nodeCache);

        $id = 9674637;
        $value = 'some value';

        $node = $this->createMock(Node::class);
        $node->expects($this->once())
            ->method('id')
            ->willReturn($id);

        $this->store->expects($this->once())
            ->method('readValue')
            ->with($id)
            ->willReturn($value);

        $result = $nodes->valueForNode($node);

        $this->assertEquals($value, $result);
    }

    public function testItFindsCommonNodes()
    {
        $nodes = $this->getMockBuilder(Nodes::class)
            ->setMethods(['read'])
            ->setConstructorArgs([$this->store, $this->nodeCache])
            ->getMock();

        $ids = [45425, 67];
        $commonIds = [5];

        $this->store->expects($this->once())
            ->method('commonNodes')
            ->with($ids)
            ->willReturn($commonIds);

        $commonNode = $this->createMock(Node::class);

        $nodes->expects($this->once())
            ->method('read')
            ->with($commonIds[0])
            ->willReturn($commonNode);

        $result = $nodes->commonNodes($ids);

        $this->assertSame([$commonNode], $result);
    }

    public function testItFiltersNodesContainingSpecifiedNode()
    {
        $nodes = new Nodes($this->store, $this->nodeCache);

        $selectorNode = $this->createMock(Node::class);

        $node_1 = $this->createMock(Node::class);
        $node_1->expects($this->once())
            ->method('has')
            ->with($selectorNode)
            ->willReturn(true);

        $node_2 = $this->createMock(Node::class);
        $node_2->expects($this->once())
            ->method('has')
            ->with($selectorNode)
            ->willReturn(false);

        $result = $nodes->filter($selectorNode, [$node_1, $node_2]);

        $this->assertSame([$node_1], $result);
    }
}