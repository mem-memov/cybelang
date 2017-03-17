<?php

namespace MemMemov\Cybelang\SpaceGraph\Node;

use PHPUnit\Framework\TestCase;

class NodeCacheTest extends TestCase
{
    public function testItSetsNode()
    {
        /** @var NodeCache|\PHPUnit_Framework_MockObject_MockObject $nodeCache */
        $nodeCache = $this->getMockBuilder(NodeCache::class)
            ->setMethods(['has'])
            ->getMock();

        $nodeId = 23;

        $node = $this->createMock(Node::class);

        $node->expects($this->once())
            ->method('id')
            ->willReturn($nodeId);

        $nodeCache->expects($this->once())
            ->method('has')
            ->with($nodeId)
            ->willReturn(false);

        $nodeCache->set($node);
    }

    public function testItForbidsNonUniqueNodeInstances()
    {
        /** @var NodeCache|\PHPUnit_Framework_MockObject_MockObject $nodeCache */
        $nodeCache = $this->getMockBuilder(NodeCache::class)
            ->setMethods(['has', 'get'])
            ->getMock();

        $nodeId = 23;

        $node = $this->createMock(Node::class);

        $node->expects($this->once())
            ->method('id')
            ->willReturn($nodeId);

        $nodeCache->expects($this->once())
            ->method('has')
            ->with($nodeId)
            ->willReturn(true);

        $duplicateNode = $this->createMock(Node::class);

        $nodeCache->expects($this->once())
            ->method('get')
            ->with($nodeId)
            ->willReturn($duplicateNode);

        $this->expectException(ForbidNonUniqueInstancesInCache::class);

        $nodeCache->set($node);
    }

    public function testItChecksItContainsANode()
    {
        $nodeCache = new NodeCache();

        $nodeId = 23;

        $node = $this->createMock(Node::class);

        $node->expects($this->once())
            ->method('id')
            ->willReturn($nodeId);

        $nodeCache->set($node);

        $result = $nodeCache->has($nodeId);

        $this->assertTrue($result);
    }

    public function testItChecksItDoesNotContainANode()
    {
        $nodeCache = new NodeCache();

        $nodeId = 23;

        $result = $nodeCache->has($nodeId);

        $this->assertFalse($result);
    }

    public function testItSuppliesANode()
    {
        /** @var NodeCache|\PHPUnit_Framework_MockObject_MockObject $nodeCache */
        $nodeCache = $this->getMockBuilder(NodeCache::class)
            ->setMethods(['has'])
            ->getMock();

        $nodeId = 23;

        $node = $this->createMock(Node::class);

        $node->expects($this->once())
            ->method('id')
            ->willReturn($nodeId);

        $nodeCache->set($node);

        $nodeCache->expects($this->once())
            ->method('has')
            ->with($nodeId)
            ->willReturn(true);

        $result = $nodeCache->get($nodeId);

        $this->assertSame($node, $result);
    }

    public function testItComplainsWhenItCanNotSupplyAMissingNode()
    {
        /** @var NodeCache|\PHPUnit_Framework_MockObject_MockObject $nodeCache */
        $nodeCache = $this->getMockBuilder(NodeCache::class)
            ->setMethods(['has'])
            ->getMock();

        $nodeId = 23;

        $nodeCache->expects($this->once())
            ->method('has')
            ->with($nodeId)
            ->willReturn(false);

        $this->expectException(ComplainAboutItemsMissingInCache::class);

        $nodeCache->get($nodeId);
    }
}