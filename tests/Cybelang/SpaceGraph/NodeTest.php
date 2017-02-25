<?php

namespace MemMemov\Cybelang\SpaceGraph;

use PHPUnit\Framework\TestCase;

class NodeTest extends TestCase
{
    /** @var Store|\PHPUnit_Framework_MockObject_MockObject */
    protected $store;

    protected function setUp()
    {
        $this->store = $this->createMock(Store::class);
    }

    public function testItHasId()
    {
        $id = 5;

        $node = new Node($id, [], $this->store);

        $result = $node->id();

        $this->assertEquals($id, $result);
    }

    public function testItChecksConnectionToAnotherNode()
    {
        $node = new Node(5, [2], $this->store);

        $aNode = $this->createMock(Node::class);

        $aNode->expects($this->once())
            ->method('id')
            ->willReturn(2);

        $result = $node->has($aNode);

        $this->assertTrue($result);
    }

    public function testItChecksNoConnectionToAnotherNode()
    {
        $node = new Node(5, [3], $this->store);

        $aNode = $this->createMock(Node::class);

        $aNode->expects($this->once())
            ->method('id')
            ->willReturn(2);

        $result = $node->has($aNode);

        $this->assertFalse($result);
    }

    public function testItChecksItIsInsideAGroupOfNodes()
    {
        $node = new Node(5, [], $this->store);

        $aNode = $this->createMock(Node::class);

        $aNode->expects($this->once())
            ->method('id')
            ->willReturn(5);

        $result = $node->in([$aNode]);

        $this->assertTrue($result);
    }

    public function testItChecksItIsNotInsideAGroupOfNodes()
    {
        $node = new Node(5, [], $this->store);

        $aNode = $this->createMock(Node::class);

        $aNode->expects($this->once())
            ->method('id')
            ->willReturn(2);

        $result = $node->in([$aNode]);

        $this->assertFalse($result);
    }

    public function testItGivesAccessToAllSubnodes()
    {
        $node = new Node(5, [2], $this->store);

        $this->store->expects($this->once())
            ->method('readNode')
            ->with(2)
            ->willReturn([888871]);

        $result = $node->all();

        $this->assertInstanceOf(Node::class, $result[0]);
    }

    public function testItGetsConnectedToANode()
    {
        $node = new Node(5, [], $this->store);

        $aNode = $this->createMock(Node::class);

        $aNode->expects($this->once())
            ->method('id')
            ->willReturn(2);

        $this->store->expects($this->once())
            ->method('connectNodes')
            ->with(5, 2);

        $node->add($aNode);
    }

    public function testItHasOnlyOneConnectionWithANode()
    {
        $node = new Node(5, [], $this->store);

        $aNode = $this->createMock(Node::class);

        $aNode->expects($this->exactly(5))
            ->method('id')
            ->willReturn(2);

        $this->store->expects($this->once())
            ->method('connectNodes')
            ->with(5, 2);

        $node->add($aNode);
        $node->add($aNode);
        $node->add($aNode);
        $node->add($aNode);
        $node->add($aNode);
    }
}