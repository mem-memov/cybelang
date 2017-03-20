<?php

namespace MemMemov\Cybelang\SpaceGraph\Node;

use PHPUnit\Framework\TestCase;

class NodeTest extends TestCase
{
    /** @var int */
    protected $id;
    /** @var Store|\PHPUnit_Framework_MockObject_MockObject */
    protected $store;

    protected function setUp()
    {
        $this->id = 5;
        $this->store = $this->createMock(Store::class);
    }

    public function testItHasId()
    {
        $node = new Node($this->id, [], $this->store);

        $result = $node->id();

        $this->assertEquals($this->id, $result);
    }

    public function testItChecksConnectionToAnotherNode()
    {
        $node = new Node($this->id, [2], $this->store);

        $aNode = $this->createMock(Node::class);

        $aNode->expects($this->once())
            ->method('id')
            ->willReturn(2);

        $result = $node->has($aNode);

        $this->assertTrue($result);
    }

    public function testItChecksNoConnectionToAnotherNode()
    {
        $node = new Node($this->id, [3], $this->store);

        $aNode = $this->createMock(Node::class);

        $aNode->expects($this->once())
            ->method('id')
            ->willReturn(2);

        $result = $node->has($aNode);

        $this->assertFalse($result);
    }

    public function testItChecksItIsInsideAGroupOfNodes()
    {
        $node = new Node($this->id, [], $this->store);

        $aNode = $this->createMock(Node::class);

        $aNode->expects($this->once())
            ->method('id')
            ->willReturn($this->id);

        $result = $node->in([$aNode]);

        $this->assertTrue($result);
    }

    public function testItChecksItIsNotInsideAGroupOfNodes()
    {
        $node = new Node($this->id, [], $this->store);

        $aNode = $this->createMock(Node::class);

        $aNode->expects($this->once())
            ->method('id')
            ->willReturn(2);

        $result = $node->in([$aNode]);

        $this->assertFalse($result);
    }

    public function testItGivesAccessToAllSubnodes()
    {
        $node = new Node($this->id, [2], $this->store);

        $this->store->expects($this->once())
            ->method('readNode')
            ->with(2)
            ->willReturn([888871]);

        $result = $node->all();

        $this->assertInstanceOf(Node::class, $result[0]);
    }

    public function testItGetsConnectedToANode()
    {
        $node = new Node($this->id, [], $this->store);

        $aNode = $this->createMock(Node::class);

        $aNode->expects($this->once())
            ->method('id')
            ->willReturn(2);

        $this->store->expects($this->once())
            ->method('connectNodes')
            ->with($this->id, 2);

        $node->add($aNode);
    }

    public function testItHasOnlyOneConnectionWithANode()
    {
        $node = new Node($this->id, [], $this->store);

        $aNode = $this->createMock(Node::class);

        $aNode->expects($this->exactly(5))
            ->method('id')
            ->willReturn(2);

        $this->store->expects($this->once())
            ->method('connectNodes')
            ->with($this->id, 2);

        $node->add($aNode);
        $node->add($aNode);
        $node->add($aNode);
        $node->add($aNode);
        $node->add($aNode);
    }
    
    public function testItExchangesSubnodes()
    {
        $oldNodeId = 23452;
        $newNodeId = 5000004;
        
        $node = new Node($this->id, [$oldNodeId], $this->store);

        $oldNode = $this->createMock(Node::class);
        $newNode = $this->createMock(Node::class);
        
        $oldNode->expects($this->once())
            ->method('id')
            ->willReturn($oldNodeId);
        
        $newNode->expects($this->once())
            ->method('id')
            ->willReturn($newNodeId);
        
        $this->store->expects($this->once())
            ->method('exchangeNodes')
            ->with($this->id, $oldNodeId, $newNodeId);
        
        $node->exchange($oldNode, $newNode);
    }
    
    public function testItForbidsExchangingMissingNode()
    {
        $oldNodeId = 23452;
        $newNodeId = 5000004;
        
        $node = new Node($this->id, [], $this->store);

        $oldNode = $this->createMock(Node::class);
        $newNode = $this->createMock(Node::class);
        
        $this->expectException(ForbidExchangingMissingNode::class);
        
        $node->exchange($oldNode, $newNode);
    }
}