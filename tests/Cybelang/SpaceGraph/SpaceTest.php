<?php

namespace MemMemov\Cybelang\SpaceGraph;

use PHPUnit\Framework\TestCase;

class SpaceTest extends TestCase
{
    /** @var string */
    protected $name;
    /** @var Node|\PHPUnit_Framework_MockObject_MockObject */
    protected $node;
    /** @var Nodes|\PHPUnit_Framework_MockObject_MockObject */
    protected $nodes;

    protected function setUp()
    {
        $this->name = 'clause';
        $this->node = $this->createMock(Node::class);
        $this->nodes = $this->createMock(Nodes::class);
    }

    public function testItHasId()
    {
        $space = new Space($this->name, $this->node, $this->nodes);

        $id = 53058;

        $this->node->expects($this->once())
            ->method('id')
            ->willReturn($id);

        $result = $space->id();

        $this->assertEquals($id, $result);
    }

    public function testItHasName()
    {
        $space = new Space($this->name, $this->node, $this->nodes);

        $result = $space->name();

        $this->assertEquals($this->name, $result);
    }

    public function testItCreatesCommonNode()
    {
        $space = new Space($this->name, $this->node, $this->nodes);

        $node_1 = $this->createMock(Node::class);
        $node_2 = $this->createMock(Node::class);
        $commonNode = $this->createMock(Node::class);

        $this->nodes->expects($this->once())
            ->method('createCommonNode')
            ->with([$node_1, $node_2])
            ->willReturn($commonNode);

        $result = $space->createCommonNode([$node_1, $node_2]);

        $this->assertSame($commonNode, $result);
    }

    public function testItCreatesNodeForValue()
    {
        $space = new Space($this->name, $this->node, $this->nodes);

        $value = 'cat';

        $node = $this->createMock(Node::class);

        $this->nodes->expects($this->once())
            ->method('nodeForValue')
            ->with($value)
            ->willReturn($node);

        $node->expects($this->once())
            ->method('add')
            ->with($this->node);

        $result = $space->createNodeForValue($value);

        $this->assertSame($node, $result);
    }

    public function testItGetsOneSubnode()
    {
        $space = new Space($this->name, $this->node, $this->nodes);

        $subnode_1 = $this->createMock(Node::class);
        $subnode_2 = $this->createMock(Node::class);

        $node = $this->createMock(Node::class);

        $node->expects($this->once())
            ->method('all')
            ->willReturn([$subnode_1, $subnode_2]);

        $this->nodes->expects($this->once())
            ->method('filter')
            ->with($this->node, [$subnode_1, $subnode_2])
            ->willReturn([$subnode_1]);

        $result = $space->getOneNode($node);

        $this->assertSame($subnode_1, $result);
    }

    public function testItRequiresOneNodeWhenGettingASubnodeAndFindingNone()
    {
        $space = new Space($this->name, $this->node, $this->nodes);

        $node = $this->createMock(Node::class);

        $node->expects($this->once())
            ->method('all')
            ->willReturn([]);

        $this->nodes->expects($this->once())
            ->method('filter')
            ->with($this->node, [])
            ->willReturn([]);

        $this->expectException(RequireOneNode::class);

        $space->getOneNode($node);
    }

    public function testItRequiresOneNodeWhenGettingASubnodeAndFindingMany()
    {
        $space = new Space($this->name, $this->node, $this->nodes);

        $subnode_1 = $this->createMock(Node::class);
        $subnode_2 = $this->createMock(Node::class);

        $node = $this->createMock(Node::class);

        $node->expects($this->once())
            ->method('all')
            ->willReturn([$subnode_1, $subnode_2]);

        $this->nodes->expects($this->once())
            ->method('filter')
            ->with($this->node, [$subnode_1, $subnode_2])
            ->willReturn([$subnode_1, $subnode_2]);

        $this->expectException(RequireOneNode::class);

        $space->getOneNode($node);
    }

    public function testItFindsNodesItContains()
    {
        $space = new Space($this->name, $this->node, $this->nodes);

        $subnode_1 = $this->createMock(Node::class);
        $subnode_2 = $this->createMock(Node::class);

        $node = $this->createMock(Node::class);

        $node->expects($this->once())
            ->method('all')
            ->willReturn([$subnode_1, $subnode_2]);

        $this->nodes->expects($this->once())
            ->method('filter')
            ->with($this->node, [$subnode_1, $subnode_2])
            ->willReturn([$subnode_1, $subnode_2]);

        $result = $space->findNodes($node);

        $this->assertSame([$subnode_1, $subnode_2], $result);
    }

    public function testItReadsNode()
    {
        $space = new Space($this->name, $this->node, $this->nodes);

        $id = 8;

        $node = $this->createMock(Node::class);

        $node->expects($this->once())
            ->method('has')
            ->with($this->node)
            ->willReturn(true);

        $this->nodes->expects($this->once())
            ->method('read')
            ->with($id)
            ->willReturn($node);

        $result = $space->readNode($id);

        $this->assertSame($node, $result);
    }

    public function testItDoesNotReadNodesItDoesNotContain()
    {
        $space = new Space($this->name, $this->node, $this->nodes);

        $id = 8;

        $node = $this->createMock(Node::class);

        $node->expects($this->once())
            ->method('has')
            ->with($this->node)
            ->willReturn(false);

        $this->nodes->expects($this->once())
            ->method('read')
            ->with($id)
            ->willReturn($node);

        $this->expectException(NodeNotFoundInSpace::class);

        $space->readNode($id);
    }

    public function testItChecksIfItContainsANode()
    {
        $space = new Space($this->name, $this->node, $this->nodes);

        $node = $this->createMock(Node::class);

        $node->expects($this->once())
            ->method('has')
            ->with($this->node)
            ->willReturn(true);

        $result = $space->has($node);

        $this->assertTrue($result);
    }

    public function testItChecksIfItDoesNotContainANode()
    {
        $space = new Space($this->name, $this->node, $this->nodes);

        $node = $this->createMock(Node::class);

        $node->expects($this->once())
            ->method('has')
            ->with($this->node)
            ->willReturn(false);

        $result = $space->has($node);

        $this->assertFalse($result);
    }

    public function testItFiltersNodes()
    {
        $space = new Space($this->name, $this->node, $this->nodes);

        $node_1 = $this->createMock(Node::class);

        $node_1->expects($this->once())
            ->method('has')
            ->with($this->node)
            ->willReturn(false);

        $node_2 = $this->createMock(Node::class);

        $node_2->expects($this->once())
            ->method('has')
            ->with($this->node)
            ->willReturn(true);

        $result = $space->filter([$node_1, $node_2]);

        $this->assertSame([$node_2], $result);
    }
}